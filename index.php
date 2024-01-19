<?php

require 'vendor/autoload.php';

use App\Http\RouteProvider;
use App\Http\Router;

(new RouteProvider())->configure();

$router = Router::getInstance();

$router->handleRequest();
