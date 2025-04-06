<?php

namespace ycanga\CentralLogger;

use Monolog\Handler\AbstractProcessingHandler;
use Monolog\Logger;
use Monolog\LogRecord;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException as GuzzleExceptionAlias;

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

        $levelName = Logger::getLevelName($record->level);

        $client = new Client();
        $headers = [
            'x-api-key' => $this->apiKey,
            'Content-Type' => 'application/json',
        ];

        $data = [
            'level' => $levelName,
            'message' => $record->message,
            'context' => $record->context,
            'datetime' => $record->datetime->format('Y-m-d H:i:s')
        ];

        try {
            $client->post($this->endpoint, [
                'headers' => $headers,
                'json' => $data,
            ]);

            Log::stack(['single', 'daily'])->log($levelName, $record->message, $record->context);
        } catch (GuzzleExceptionAlias $e) {
            Log::stack(['single', 'daily'])->log('API request failed: ' . $e->getMessage(), $record->context);
            return;
        }
    }
}
