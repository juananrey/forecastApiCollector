<?php

namespace ForecastBundle\Listener;

use Symfony\Component\HttpKernel\Event\GetResponseForExceptionEvent;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\HttpExceptionInterface;

class ExceptionListener
{
    public function onKernelException(GetResponseForExceptionEvent $event)
    {
        $exception = $event->getException();
        $response = new Response();

        // We set the exception known message here if it's on an HTTP level. Otherwise, we return an Internal Server Error
        if ($exception instanceof HttpExceptionInterface) {
            $response->setStatusCode($exception->getStatusCode());
            $response->setContent($exception->getMessage());
            $response->headers->replace($exception->getHeaders());

        } else {
            $response->setStatusCode(Response::HTTP_INTERNAL_SERVER_ERROR);
            $response->setContent('Internal Server Error');
        }

        $event->setResponse($response);
    }
}
