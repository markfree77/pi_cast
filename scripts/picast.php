<?php
if (file_exists(dirname(dirname(__FILE__)) . '/config.inc.php')) {
    require_once dirname(dirname(__FILE__)) . '/config.inc.php';
} else {
    require dirname(dirname(__FILE__)) . '/config.sample.php';
}

use PiCast\Config;

$cachePath = Config::get('CACHE_DIR') . "cache.json";

$data                       = array();
$data['SERVER_SENDER_ADDR'] = Config::get('SERVER_SENDER_ADDR');
$data['SERVER_SENDER_PATH'] = Config::get('SERVER_SENDER_PATH');
$data['SECRET']             = Config::get('SECRET');

$encodedData = json_encode($data);

$cache = @file_get_contents($cachePath);

if ($cache == $encodedData) {
    return;
}

$data = 'SERVER_SENDER_ADDR=' . Config::get('SERVER_SENDER_ADDR')
      . '&SERVER_SENDER_PATH=' . Config::get('SERVER_SENDER_PATH')
      . '&SECRET=' . Config::get('SECRET');

$ch = curl_init(Config::get('SERVER_RECEIVER_URL'));

curl_setopt($ch, CURLOPT_POST, 1);
curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
curl_setopt($ch, CURLOPT_FOLLOWLOCATION, 1);
curl_setopt($ch, CURLOPT_HEADER, 0);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_POSTREDIR, 3);

$response = curl_exec($ch);

if ($response == 'SUCCESS') {
    file_put_contents($cachePath, $encodedData);
}