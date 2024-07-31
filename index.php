<?php
declare(strict_types=1);
require_once "vendor/autoload.php";

use Dotenv\Dotenv;
$dotenv = Dotenv::createImmutable(__DIR__);
$dotenv->load();


require_once "bot/bot.php";
