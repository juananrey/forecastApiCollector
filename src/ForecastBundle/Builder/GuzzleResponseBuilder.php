<?php

namespace ForecastBundle\Builder;

use ForecastBundle\Exception\ForecastApiException;
use GuzzleHttp\Exception\RequestException;

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
                $this->handleResponseException($response);

            } else {
                $result[] = json_decode($response->getBody(), true);
            }
        }

        return $result;
    }

    private function handleResponseException(RequestException $response)
    {
        if (false === $this->allowFailedQueries) {
            $exceptionResponse = $response->getResponse();
            $statusCode = $exceptionResponse->getStatusCode();
            $messsage = $exceptionResponse->getReasonPhrase();

            throw new ForecastApiException($statusCode, $messsage);
        }
    }
}