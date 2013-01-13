<?php
if (file_exists(dirname(dirname(__FILE__)) . '/config.inc.php')) {
    require_once dirname(dirname(__FILE__)) . '/config.inc.php';
} else {
    require dirname(dirname(__FILE__)) . '/config.sample.php';
}

use PiCast\Config;

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

print_r($response);