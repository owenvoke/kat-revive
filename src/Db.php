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
     * @return \PDO
     */
    public static function conn()
    {
        if (!is_a(self::$Conn, '\\PDO')) {
            self::$Conn = new \PDO(
                Config::DB_DSN,
                Config::DB_USER,
                Config::DB_PASS
            );

            return self::$Conn;
        }

        return self::$Conn;
    }
}