<?php

namespace ycanga\CentralLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Http;

class LoggerHandler extends AbstractProcessingHandler
{
    protected $endpoint;
    protected $apiKey;

    public function __construct($level = Logger::DEBUG, $bubble = true)
    {
        parent::__construct($level, $bubble);
        $this->endpoint = config('central-logger.endpoint');
        $this->apiKey = config('central-logger.api_key');
    }

    protected function write(LogRecord $record): void
    {
        if (!$this->endpoint || !$this->apiKey) return;

        Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
        ])->post($this->endpoint, [
            'message' => $record->message,
            'level' => $record->levelName,
            'datetime' => $record->datetime->format('Y-m-d H:i:s'),
            'context' => $record->context,
        ]);
    }
}
