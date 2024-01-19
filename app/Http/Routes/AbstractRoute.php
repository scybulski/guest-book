<?php

namespace App\Http\Routes;

abstract class AbstractRoute implements RouteContract
{
    public function canHandle(string $method, string $uri): bool
    {
        return strtolower($method) === strtolower($this->method())
            && static::doesUriMatch($uri);
    }

    public function doesUriMatch(string $requestUri): bool
    {
        $onlyPath = parse_url($requestUri, PHP_URL_PATH);

        return trim($onlyPath, '/') === trim($this->uri(), '/');
    }
}
