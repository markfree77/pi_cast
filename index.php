<?php
if (file_exists(dirname(__FILE__) . '/config.inc.php')) {
    require_once dirname(__FILE__) . '/config.inc.php';
} else {
    require dirname(__FILE__) . '/config.sample.php';
}

use PiCast\Config;

$cachePath = Config::get('CACHE_DIR') . "cache.json";

if (isset($_POST['SERVER_SENDER_ADDR'], $_POST['SERVER_SENDER_PATH'], $_POST['SECRET'])) {
    if ($_POST['SECRET'] != Config::get('SECRET')) {
        throw new \Exception("You do not have permission to do that.", 400);
    }

    //Do not store the secret.
    unset($_POST['SECRET']);

    $_POST['MODIFY_DATE'] = date("F j, Y, g:i a");

    file_put_contents($cachePath, json_encode($_POST));
}

if (!$data = file_get_contents($cachePath)) {
    throw new \Exception("Error getting cache.  Reporting server has not checked in yet, or permissions are not set", 500);
}

if (!$data = json_decode($data, true)) {
    throw new \Exception('Cache data was not formatted correctly');
}

if (isset($_GET['debug'])) {
    var_dump($data); exit();
}

//Redirect
header('Location: http://' . $data['SERVER_SENDER_ADDR'] . "/" . $data['SERVER_SENDER_PATH']);