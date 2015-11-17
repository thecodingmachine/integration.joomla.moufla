<?php

namespace Mouf\Integration\Joomla\Moufla;

use Mouf;
use Mouf\Mvc\Splash;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use Zend\Diactoros\ServerRequestFactory;
use Zend\Diactoros\Response;

class Moufla {

    /**
     * This function will ask the Mouf router for routes. A PSR-7 response will be returned with content, or a Vary
     * array set with the value 'mouflaNotFound' at the first pos
     * @return ResponseInterface
     */
    public function searchForRoute() {
        //$router = Mouf::getSplashDefaultRouter();
        $router = Mouf::getSplashMiddleware();

        $request = ServerRequestFactory::fromGlobals(
            $_SERVER,
            $_GET,
            $_POST,
            $_COOKIE,
            $_FILES
        );
        $response = new Response();

        $response = $router($request, $response, function(RequestInterface $request, ResponseInterface $response) {
            return $response->withHeader("Vary", "mouflaNotFound")->withStatus(404, "Mouf component not found");
        });
        return $response;
    }
}
