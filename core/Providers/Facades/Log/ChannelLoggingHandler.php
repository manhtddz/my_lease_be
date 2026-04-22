<?php

namespace Core\Providers\Facades\Log;

use Core\Helpers\ChatWork\ChatWork;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Route;
use Monolog\Formatter\LineFormatter;
use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\AbstractHandler;
use Monolog\Level;
use Monolog\Logger;
use Monolog\LogRecord;

class ChannelLoggingHandler extends AbstractProcessingHandler
{
    const LOG_WALL = '';

    const LOG_DELIMITER = ' | ';

    const LOG_EOL = "\n";

    protected string $logFormatter = "%message% %context% %extra%\n";

    public function __construct(int|string|Level $level = Level::Debug, bool $bubble = true)
    {
        parent::__construct($level, $bubble);
    }

    /**
     * set log level
     *
     * @param int|string|Level $level
     * @return AbstractHandler
     */
    public function setLevel(int|string|Level $level): AbstractHandler
    {
        $level = Level::fromName(config('logging.channels.custom.level'));
        return parent::setLevel($level);
    }

    /**
     * write log
     *
     * @param LogRecord $record
     */
    protected function write(LogRecord $record): void
    {
        $this->writeLog($record->level->value, $record->message, $record->context);
    }

    /**
     * @param $level
     * @param $message
     * @param array $context
     */
    protected function writeLog($level, $message, array $context = [])
    {
        if (empty($level)) {
            $level = Level::Debug->value;
        }

        if (is_array($message)) {
            $message = jsonEncode($message);
        }

        $isCmd = App::runningInConsole();

        // get action/method
        $currentAction = Route::currentRouteAction();
        if (@$_SERVER['REQUEST_URI'] == '/livewire/update'){
            $components = request()->json('components');
            $firstComponent = !empty($components[0]) ? $components[0] : null;
            $livewireMethod = !empty($firstComponent['calls'][0]['method']) ? $firstComponent['calls'][0]['method']: '';
            if ($livewireMethod == '__dispatch' && !empty($firstComponent['calls'][0]['params'][0])){
                $livewireMethod = $firstComponent['calls'][0]['params'][0];
            }
            $livewireComponentName = !empty($firstComponent['snapshot']) ? 'livewire:' . json_decode($firstComponent['snapshot'])->memo->name : '';
            $currentAction = $livewireComponentName . '@' . $livewireMethod;
        }

        $serverInfo =
            self::LOG_WALL . ($level == Level::Debug->value ? '#SQL in Request: ' : '#Request: ').
            // Log output items (Request URI..WEB only)
            self::LOG_WALL . 'URI=' . @$_SERVER['REQUEST_URI'] . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output item (controller name)
            //self::LOG_WALL . 'CONTROLLER=' . ($isCmd ? @$_SERVER['argv'][1] : (!empty(Route::currentRouteAction()) ? Route::currentRouteAction() : '')) . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output item (action name)
            self::LOG_WALL . 'ACTION=' . ($isCmd ? @$_SERVER['argv'][2] : $currentAction ) . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output item (execution script name)
            self::LOG_WALL . 'SCRIPT=' . ($isCmd ? base_path() . '/' . 'artisan' : @$_SERVER['SCRIPT_NAME']) . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output item (server name)
            self::LOG_WALL . 'SERVER=' . ($isCmd ? env('APP_URL', '') : @$_SERVER['SERVER_NAME']) . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output item (server address)
            self::LOG_WALL . 'IP=' . ($isCmd ? @gethostbyname(php_uname('n')) : getClientIp()) . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output items (Access USER AGENT..WEB only)
            self::LOG_WALL . 'AGENT=' . ($isCmd ? @php_uname() : @$_SERVER['HTTP_USER_AGENT']) . self::LOG_WALL . self::LOG_DELIMITER .
            // Log output referer
            self::LOG_WALL . 'REFERER=' . @$_SERVER['HTTP_REFERER'] . self::LOG_WALL . self::LOG_DELIMITER;


        // level
        $levelName = strtolower(Level::fromValue($level)->name);

        // filename
        // override log path
        $filename = getArea();
        if (!empty($context['path'])) {
            $isLogx = true;
            $filename = $context['path'];
            $filePath = storage_path('logs/' . date('Y-m-d') . '/' . $filename . '.log');
            $label = "[".substr($levelName, 0, 3)."]";
            unset($context['path']);
        }else{
            $label = '';
            $filePath = !empty($filePath) ? $filePath : storage_path('logs/' . date('Y-m-d') . '/' . $filename . '.' . $levelName . '.log');
        }

        // Log output prefix Context
        if(!empty($context)){
            $serverInfo .= "\n" . '#Context: ';
        }

        // log message
        $label = '[' . date('Y-m-d H:i:s') . ']' . ' ' . $label;
        $log = $label . ' ' . $message;

        // send message to ChatWork
        $this->_sendToChatWork($level, $log, $serverInfo);

        // set handler
        $handler = new StreamHandler($filePath, $level);
        $handler->setFormatter(new LineFormatter($this->logFormatter, 'Y-m-d H:i:s', true, true));

        // message
        $message = "\n" . $log . "\n" . $serverInfo;

        // _reqCode for debug
        if ($level == Level::Debug->value || !empty($isLogx)){
            $uniqueReqCode = request()->server('REQUEST_URI') .'_'. request()->server('REQUEST_TIME');
            if (session('_reqCode') == $uniqueReqCode){
                $message = $log;
            }else{
                $message = "\n" . $serverInfo . "\n" . $log;
            }
        }

        // write log
        $logger = new Logger('custom');
        $logger->pushHandler($handler);
        $logger->{$this->_getLogName($level)}($message, $context);
    }

    /**
     * send message to ChatWork
     *
     * @param $level
     * @param $log
     * @param $serverInfo
     * @throws \Exception
     */
    protected function _sendToChatWork($level, $log, $serverInfo)
    {
        $isSend = in_array($level, [Level::Error->value, Level::Critical->value, Level::Emergency->value]);

        if (isEnableChatWork() && $isSend && !$this->_skipPushToChatWork($log, $serverInfo)) {
            $msgToChatWork = $log;
            $msgLength = mb_strlen($msgToChatWork);
            $msgMaxLength = config('services.chat_work.message_max_length');
            if ($msgLength > $msgMaxLength) {
                $msgToChatWork = mb_substr($msgToChatWork, 0, $msgMaxLength) . '...';
            }

            $msgChatWork = "[code]ログファイル[" . getArea() . '.' . $this->_getLogName($level). ".log]" . "\n"
                . $msgToChatWork . '"' . "\n"
                . $serverInfo
                . "[/code]";

            // send to ChatWork
            $chatWork = new ChatWork();
            $roomId = config('services.chatwork.room_id_error');
            $chatWork->writeMessage($msgChatWork, $roomId);
        }
    }

    protected function _skipPushToChatWork(string $log, string $serverInfo): bool
    {
        foreach ([$log, $serverInfo] as $haystack) {
            if (str_contains($haystack, 'NotFoundHttpException') || str_contains($haystack, 'ViteManifestNotFoundException')) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param $level
     * @return string
     */
    protected function _getLogName($level): string
    {
        return match ($level) {
            Level::Debug->value => 'debug',
            Level::Info->value => 'info',
            Level::Notice->value => 'notice',
            Level::Warning->value => 'warning',
            Level::Error->value => 'error',
            Level::Critical->value => 'critical',
            Level::Alert->value => 'alert',
            Level::Emergency->value => 'emergency',
        };
    }
}
