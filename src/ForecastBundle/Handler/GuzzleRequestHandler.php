<?php

namespace ForecastBundle\Handler;

use GuzzleHttp\Client;
use GuzzleHttp\Pool;
use GuzzleHttp\Psr7\Request;

class GuzzleRequestHandler implements RequestHandlerInterface
{
    private $apiUrl;
    private $apiKey;
    private $client;

    public function __construct($apiUrl, $apiKey)
    {
        $this->apiUrl = $apiUrl;
        $this->apiKey = $apiKey;

        $baseUri = $this->apiUrl.'/'.$this->apiKey.'/';
        $this->client = new Client(['base_uri' => $baseUri]);
    }

    public function getConcurrentResponses($httpMethod, $endpoints, $concurrentRequestsNumber)
    {
        $requests = [];
        foreach ($endpoints as $endpoint) {
            $requests[] = new Request($httpMethod, $endpoint);
        }

        return Pool::batch($this->client, $requests, ['concurrency' => $concurrentRequestsNumber]);
    }
}