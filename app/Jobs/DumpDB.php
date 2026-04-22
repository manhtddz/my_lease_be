<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Spatie\DbDumper\Databases\MySql;
use Spatie\DbDumper\Databases\PostgreSql;
use Spatie\DbDumper\Compressors\GzipCompressor;
use Exception;

class DumpDB implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    // filename
    protected string $name;

    // keep max file backup
    protected int $maxFile;

    // directory backup
    protected string $path;

    public function __construct()
    {
        $this->name = getConfig('logs.dump_db.file_name');
        $this->maxFile = getConfig('logs.dump_db.max_file');
        $this->path = getConfig('logs.dump_db.path');
    }

    public function handle()
    {
        logInfo('--- START DUMP DATABASE ---');

        try {
            $filePath = $this->path . '/' . $this->name;

            match (env('DB_CONNECTION')) {
                'mysql' => MySql::create()
                    ->setHost(env('DB_HOST'))
                    ->setPort(env('DB_PORT'))
                    ->setDbName(env('DB_DATABASE'))
                    ->setUserName(env('DB_USERNAME'))
                    ->setPassword(env('DB_PASSWORD'))
                    // ->includeTables('users, administrators')
                    // ->excludeTables('logs, logs_users')
                    ->useCompressor(new GzipCompressor())
                    ->dumpToFile($filePath),
                'pgsql' => PostgreSql::create()
                    ->setHost(env('DB_HOST'))
                    ->setPort(env('DB_PORT'))
                    ->setDbName(env('DB_DATABASE'))
                    ->setUserName(env('DB_USERNAME'))
                    ->setPassword(env('DB_PASSWORD'))
                    // ->includeTables('users, administrators')
                    // ->excludeTables('logs, logs_users')
                    ->useCompressor(new GzipCompressor())
                    ->dumpToFile($filePath)
            };
            $this->_deleteFiles();
            logInfo("Dump database success. File path {$filePath}");
        } catch (Exception $exception) {
            logError("Dump database error.");
            logError($exception->getMessage() . PHP_EOL . $exception->getTraceAsString());
        }
        logInfo('--- END DUMP DATABASE ---');
    }

    protected function _deleteFiles()
    {
        $files = array_diff(scandir($this->path), ['.', '..', '.gitignore']);
        $files = array_values($files);
        if (count($files) >= $this->maxFile) {
            $lists = array_slice($files, 0, count($files) - $this->maxFile);
            if (!empty($lists)) {
                foreach ($lists as $list) {
                    $name = $this->path . '/' . $list;
                    logInfo("Delete file {$name}");
                    unlink($name);
                }
            }
        }
    }
}
