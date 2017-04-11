<?php

namespace pxgamer\KatRevive;

/**
 * Class Db
 * @package pxgamer\KatRevive
 */
class Db
{
    public static $Conn;

    /**
     * @return \mysqli
     */
    public static function conn()
    {
        if (!is_a(self::$Conn, '\\mysqli')) {
            self::$Conn = new \mysqli(
                Config::DB_HOST,
                Config::DB_USER,
                Config::DB_PASS,
                Config::DB_NAME
            );
        }

        return self::$Conn;
    }
}