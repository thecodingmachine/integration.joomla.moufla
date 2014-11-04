<?php

namespace Mouf\Integration\Joomla\Moufla;

use Mouf;
use Mouf\Mvc\Splash;
use Symfony\Component\HttpFoundation\Request;

class Moufla {

    /**
     * This function will ask the Mouf router for routes. A Symfony response will be return with content, or a Vary
     * array set with the value 'mouflaNotFound' at the first pos
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function searchForRoute() {
        $router = Mouf::getSplashDefaultRouter();
        $request = Request::createFromGlobals();
        $response = $router->handle($request);
        return $response;
    }
}