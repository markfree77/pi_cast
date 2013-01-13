<?php
use PiCast\Config;

/**********************************************************************************************************************
 * autoload and include path
 */
function autoload($class)
{
    $file = str_replace(array('_', '\\'), '/', $class).'.php';
    if ($fullpath = stream_resolve_include_path($file)) {
        include $fullpath;
        return true;
    }
    return false;
}

spl_autoload_register("autoload");

set_include_path(
    implode(PATH_SEPARATOR, array(get_include_path())).PATH_SEPARATOR
        .dirname(__FILE__) . '/src'.PATH_SEPARATOR
);

/**********************************************************************************************************************
 * php related settings
 */

ini_set('display_errors', false);

error_reporting(E_ALL);

/**********************************************************************************************************************
 * PiCast related settings
 */

Config::set('SERVER_RECEIVER_URL', 'http://wwww.theremoteserver.com/picast/index.php');
Config::set('SERVER_SENDER_PATH' , 'path/that/receiving/server/should/redirect/to/');
Config::set('SECRET'             , 'super cool secret key');