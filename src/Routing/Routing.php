<?php

namespace pxgamer\KatRevive\Routing;

/**
 * Class Routing
 * @package pxgamer\KatRevive\Routing
 */
class Routing
{
    /**
     * Routing constructor.
     */
    function __construct()
    {
        define('DS', DIRECTORY_SEPARATOR, true);
        define('BASE_PATH', __DIR__ . DS, true);

        $app = \System\App::instance();
        $app->request = \System\Request::instance();
        $app->route = \System\Route::instance($app->request);

        $route = Routes::register($app->route);

        $route->end();
    }
}