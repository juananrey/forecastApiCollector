<?php

namespace ForecastBundle\Service;

use ForecastBundle\Builder\ResponseBuilderInterface;
use ForecastBundle\Handler\RequestHandlerInterface;

class ForecastApiService
{
    private $requestHandler;
    private $responseBuilder;
    private $concurrentRequestsNumber;

    public function __construct(RequestHandlerInterface $requestHandler, ResponseBuilderInterface $responseBuilder, $concurrentRequestsNumber)
    {
        $this->requestHandler = $requestHandler;
        $this->responseBuilder = $responseBuilder;
        $this->concurrentRequestsNumber = $concurrentRequestsNumber;
    }

    public function getWeatherSince($latitude, $longitude, $startingDay)
    {
        $endpoints = [];
        foreach ($this->getUnixTimestampsForDays($startingDay) as $unixTimestamp) {
            $endpoints[] = $latitude.','.$longitude.','.$unixTimestamp;
        }

        $jsonResponses = $this->requestHandler->getConcurrentResponses('GET', $endpoints, $this->concurrentRequestsNumber);

        $responses = $this->responseBuilder->convertJsonResponsesToArray($jsonResponses);

        return $this->formatApiResponses($responses);
    }

    private function getUnixTimestampsForDays($startingDay)
    {
        $unixTimestamps = [];

        $currentUnixTimestamp = time();
        $secondsPerDay = 60 * 60 * 24;

        for ($i = 0; $i < $startingDay; $i++) {
            $unixTimestamps[] = $currentUnixTimestamp - ($i * $secondsPerDay);
        }

        return $unixTimestamps;
    }

    private function formatApiResponses($responses)
    {
        $result = array();

        // Adding some dates so is visually clearer from an API point of view
        foreach ($responses as $response) {
            $currentUnixTimestamp = $response['currently']['time'];
            $currentDay = date('d-m-Y',$currentUnixTimestamp);
            $result[$currentDay] = $response;
        }

        $result = array(
            '_metadata' => array(
                'totalCount' => count($responses),
            ),
            'forecasts' => $result
        );

        return $result;
    }
}