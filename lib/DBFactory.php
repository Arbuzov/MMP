<?php

class DBFactory
{

    protected $_dbInstance = null;

    protected $_dbType = '';

    public $db;

    public function __construct ($config = array())
    {
        switch ($config['driver']) {
            case 'pdo':
                $this->db = new PDO(
                    'mysql:host='.$conf['host'].';dbname='.$conf['db'],
                    $conf['user'],
                    $conf['password']
                );
                break;
            
            default:
                $this->db = new Mysqli(
                    $conf['host'],
                    $conf['user'],
                    $conf['password'], 
                    $conf['db']
                );
                break;
        }
    }

    /**
     *
     * @param $config array
     * @return DBFactory
     */
    static function getDBInstance ($config = array())
    {
        static $db = null;
        $conf = self::$config;
        if (count($config)) {
            foreach ($config as $option => $value) {
                $conf[$option] = $value;
            }
        } else {
            if ($db)
                return $db;
            $db = new Mysqli(
                $conf['host'],
                $conf['user'],
                $conf['password'], 
                $conf['db']
            );
            return $db;
        }
        return new Mysqli(
            $conf['host'],
            $conf['user'],
            $conf['password'], 
            $conf['db']
        );
    }

    public function query($sql)
    {
        $this->db->query($sql);
    }

    public function ping()
    {
        if ($this->db instanceof Mysqli) {
            return $this->db->ping($sql);
        } else {
            return true;
        }
        
    }
    
    static function setConfig($cnf)
    {
        self::$config = array_replace(self::$config, $cnf);
    }
    
    static function getConfig()
    {
        return self::$config;
    }
}