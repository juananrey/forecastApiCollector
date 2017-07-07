<?php

namespace ForecastBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Method;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use ForecastBundle\Service\ForecastApiService;

/**
 * @Route(service="forecast.controller.main_controller")
 */
class MainController
{
    private $forecastService;

    public function __construct(ForecastApiService $forecastService)
    {
        $this->forecastService = $forecastService;
    }

    /**
     * @Route("/v1/forecast/latitude/{latitude}/longitude/{longitude}")
     * @Method({"GET"})
     */
    public function getWeatherAction(Request $request, $latitude, $longitude)
    {
        $startingDay = $request->get('daysAgo', 30);

        return new JsonResponse($this->forecastService->getWeatherSince($latitude, $longitude, $startingDay));
    }
}
