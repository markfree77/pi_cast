<?php
namespace PiCast;

class Config
{
    protected static $data = array(
        'SERVER_RECEIVER_URL' => false,  //URL to the receiving server
        'SECRET'              => false,  //Secret that must be the same between client and server.
        'SERVER_SENDER_ETH'   => 'eth0',
        'CACHE_DIR'           => false,
        'SERVER_SENDER_ADDR'  => false,
        'SERVER_SENDER_PATH'  => "",
    );

    private function __construct()
    {
        //Do nothing
    }

    public static function get($key)
    {
        if (!isset(self::$data[$key])) {
            return false;
        }

        //Special default case: SERVER_ADDR
        if ($key == 'SERVER_SENDER_ADDR' && self::$data[$key] == false) {
            if (isset($_SERVER['SERVER_ADDR'])) {
                return $_SERVER['SERVER_ADDR'];
            }

            return str_replace("\n","", exec("ifconfig " . self::$data['SERVER_SENDER_ETH'] . " | grep 'inet addr' | awk -F':' {'print $2'} | awk -F' ' {'print $1'}"));
        }

        //Special default case: CACHE_DIR
        if ($key == 'CACHE_DIR' && self::$data[$key] == false) {
            return  dirname(dirname(dirname(__FILE__))) . "/tmp/";
        }

        return self::$data[$key];
    }

    public static function set($key, $value)
    {
        return self::$data[$key] = $value;
    }
}