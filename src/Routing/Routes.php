<?php

namespace pxgamer\KatRevive\Routing;

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
        $Routes->any('/torrent/{hash}', [self::CONTROLLERS . 'Torrents', 'show']);

        return $Routes;
    }
}