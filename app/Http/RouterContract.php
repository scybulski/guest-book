<?php

namespace App\Http;

use App\Http\Routes\RouteContract;

interface RouterContract
{
    public function addRoute(RouteContract $route): self;

    public function handleRequest(): void;
}
