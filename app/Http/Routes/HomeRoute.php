<?php

namespace App\Http\Routes;

use App\Http\Enums\HttpMethod;
use App\Http\Responses\RedirectResponse;

class HomeRoute extends AbstractRoute
{
    public function method(): string
    {
        return HttpMethod::GET->value;
    }

    public function uri(): string
    {
        return '/';
    }

    public function handle(): void
    {
        (new RedirectResponse('/comments'))->render();
    }
}
