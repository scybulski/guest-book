<?php

namespace App\Http\Routes;

interface RouteContract
{
    public function method(): string;
    public function uri(): string;

    public function canHandle(string $method, string $uri): bool;

    public function handle(): void;
}
