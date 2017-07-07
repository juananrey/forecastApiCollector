<?php

namespace ForecastBundle\Exception;

class ForecastApiException extends \Exception
{
    protected $message = 'There was an error retrieving forecast data. Please try again later';
}
