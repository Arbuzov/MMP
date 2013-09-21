<?php
class DBFactory
{
    private static $_config = null;
    private static $_tmpConfig = null;

    private static $_db = null;
    private static $_tmpDb = null;

    /**
     * @param array $config
     * @return Mysqli
     *
     **/
    static function getMainInstance($config=array())
    {
        self::$_config = $config;
        self::$_db = new Mysqli(
                self::$_config['host'],
                self::$_config['user'],
                self::$_config['password'],
                self::$_config['db']
        );
        return self::$_db;
    }

    /**
     * @param array $config
     * @return Mysqli
     *
     **/
    static function getTmpInstance($currentVersion = null)
    {
        self::$_tmpConfig = self::$_config;
        self::$_tmpConfig['db'] = self::$_config['db'].'_'.$currentVersion;
        self::$_tmpDb = new Mysqli(
                self::$_tmpConfig['host'],
                self::$_tmpConfig['user'],
                self::$_tmpConfig['password'],
                self::$_tmpConfig['db']
        );
        return self::$_tmpDb;
    }
}