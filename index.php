<?php

require 'vendor/autoload.php';

use App\Http\Router;

$router = Router::getInstance();

$router->handleRequest();
