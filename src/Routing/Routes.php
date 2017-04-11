<?php

namespace pxgamer\KatRevive\Routing;

use pxgamer\KatRevive\Controller\Torrents;

/**
 * Class Routes
 * @package pxgamer\KatRevive\Routing
 */
class Routes
{
    const CONTROLLERS = '\\pxgamer\\KatRevive\\Controller\\';
    const MODELS = '\\pxgamer\\KatRevive\\Models\\';

    /**
     * @param \System\Route $Routes
     * @return \System\Route
     */
    public static function register(\System\Route $Routes)
    {
        $Routes->any('/', [self::CONTROLLERS . 'Torrents', 'index']);

        return $Routes;
    }
}