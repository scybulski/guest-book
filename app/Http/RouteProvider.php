<?php

namespace App\Http;

use App\Http\Routes\Comments\Index as CommentIndex;
use App\Http\Routes\Comments\Store as CommentStore;
use App\Http\Routes\HomeRoute;

class RouteProvider
{
    public function configure(): void
    {
        $router = Router::getInstance();

        $router->addRoute(new HomeRoute());
        $router->addRoute(new CommentIndex());
        $router->addRoute(new CommentStore());
    }
}
