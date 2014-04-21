<?php

define('APP_PATH', dirname(__DIR__) . '/apps');

// Handle the request
include APP_PATH . "/bootstrap.php";

// load the config
$config = require(APP_PATH . '/config/config.php');

Bootstrap::init( $config );
Bootstrap::run();