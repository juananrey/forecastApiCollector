<?php

namespace ForecastBundle\Handler;

interface RequestHandlerInterface
{
    /**
     * Get concurrent responses for a specific set of endpoints, with a configurable number of simultaneous requests
     *
     * @param string $httpMethod HTTP method to be used on the responses
     * @param array $endpoints endpoints to be queries
     * @param integer $concurrentRequestsNumber number of simultaneous requests to be performed
     *
     * @return array with provided responses
     */
    public function getConcurrentResponses($httpMethod, $endpoints, $concurrentRequestsNumber);
}