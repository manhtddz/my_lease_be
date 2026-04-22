<?php

namespace Core\Providers\Facades\Log;

use Monolog\Logger;

class ChannelCustomLogger
{
    /**
     * @param array $config
     * @return Logger
     */
    public function __invoke(array $config)
    {
        $logger = new Logger("ChannelLoggingHandler");
        return $logger->pushHandler(new ChannelLoggingHandler());
    }
}
