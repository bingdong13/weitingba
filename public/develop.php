<?php

//开发环境。

ini_set("display_errors","On"); 

define('APP_PATH', dirname(__DIR__) . '/apps');

// Handle the request
include APP_PATH . "/bootstrap.php";

// load the config
$config = require(APP_PATH . '/config/config.dev.php');

Bootstrap::init( $config );
Bootstrap::run();