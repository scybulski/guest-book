<?php

namespace App\Http\Routes;

abstract class AbstractRoute implements RouteContract
{
    private function __construct()
    {
    }

    public function canHandle(string $method, string $uri): bool
    {
        return strtolower($method) === strtolower($this->method())
            && static::doesUriMatch($uri);
    }

    public function doesUriMatch(string $uri): bool
    {
        return trim($uri, '/') === trim($this->uri(), '/');
    }
}
