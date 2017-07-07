<?php

namespace ForecastBundle\Builder;

use ForecastBundle\Exception\ForecastApiException;

class GuzzleResponseBuilder implements ResponseBuilderInterface
{
    private $allowFailedQueries;

    public function __construct($allowFailedQueries)
    {
        $this->allowFailedQueries = $allowFailedQueries;
    }

    public function convertJsonResponsesToArray(array $responses)
    {
        $result = [];
        foreach ($responses as $response) {
            if ($response instanceof \Exception) {
                $this->handleResponseException();

            } else {
                $result[] = json_decode($response->getBody(), true);
            }
        }

        return $result;
    }

    private function handleResponseException()
    {
        if (false === $this->allowFailedQueries) {
            throw new ForecastApiException();
        }
    }
}