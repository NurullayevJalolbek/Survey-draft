<?php

declare(strict_types=1);

session_start();

$update = json_decode(file_get_contents('php://input'));

date_default_timezone_set('Asia/Tashkent');

require "vendor/autoload.php";

if ((new Router())->checkCron()) {
    try {
        (new Router())->sendUserAds();
    } catch (GuzzleException $e) {
        echo $e->getMessage();
    }
} elseif ($update !== NULL) {
    require 'bot/bot.php';
} else {
    require 'routes/web.php';
}