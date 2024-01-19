<?php

namespace App\Http;

use App\Http\Responses\StatusPages\InternalServerError;
use App\Http\Responses\StatusPages\NotFound;
use App\Http\Routes\RouteContract;
use Exception;

final class Router implements RouterContract
{
    private static ?self $instance = null;

    /** @var array<\App\Http\Routes\RouteContract> $routes */
    private array $routes = [];

    private function __construct()
    {
    }

    private function __clone()
    {
    }

    public static function getInstance(): self
    {
        return static::$instance
            ?? static::$instance = new self();
    }

    public function addRoute(RouteContract $route): self
    {
        $this->routes[] = $route;

        return $this;
    }

    public function handleRequest(): void
    {
        $method = $_SERVER['REQUEST_METHOD'];
        $uri = $_SERVER['REQUEST_URI'];

        foreach ($this->routes as $route) {
            if ($route->canHandle($method, $uri)) {
                try {
                    $route->handle();
                } catch (Exception $e) {
                    $this->renderInternalServerError();
                }

                return;
            }
        }

        $this->renderNotFound();
    }

    private function renderNotFound(): void
    {
        (new NotFound())->render();
    }

    private function renderInternalServerError(): void
    {
        (new InternalServerError())->render();
    }
}
