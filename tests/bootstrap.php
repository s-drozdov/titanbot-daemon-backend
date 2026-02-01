<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

if (file_exists(dirname(__DIR__).'/.env')) {
    (new Dotenv())->load(dirname(__DIR__).'/.env');
}

if (file_exists(dirname(__DIR__).'/.env.test')) {
    $dotenv = new Dotenv();
    $dotenv->load(dirname(__DIR__).'/.env.test');
}

if (!isset($_SERVER['APP_ENV'])) {
    $_SERVER['APP_ENV'] = $_ENV['APP_ENV'] = 'test';
}

if ($_SERVER['APP_DEBUG'] ?? false) {
    umask(0000);
}
