<?php

session_start();

use Dotenv\Dotenv;

//for loading helpers functions
require_once __DIR__ . '/../framework/helpers.php';
//for loading Composer generated autoload classes
require_once base_path().'vendor/autoload.php';
//for web routes mapping to controllers actions
require_once base_path().'routes/web.php';

//for loading .env
$dotenv = Dotenv::createImmutable(base_path());
$dotenv->load();

app()->run();
