<?php

namespace Mouf\Integration\Joomla\Moufla;

use Mouf\Mvc\Splash;

class Moufla {

    function __construct() {
        var_dump("constructor Moufla");
        $router = \Mouf::getSplashDefaultRouter();
        $router->handle();
    }

    public function doSomething() {
        var_dump("level complete"); exit;
    }
}