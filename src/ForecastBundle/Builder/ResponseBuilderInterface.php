<?php

namespace ForecastBundle\Builder;

interface ResponseBuilderInterface
{
    /**
     * Convert to array all the JSON responses from the Forecast API
     *
     * @param array $responses
     *
     * @return array with conveniently parsed responses
     */
    public function convertJsonResponsesToArray(array $responses);
}