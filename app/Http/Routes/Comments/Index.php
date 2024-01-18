<?php

namespace App\Http\Routes\Comments;

use App\Http\Enums\HttpMethod;
use App\Http\Routes\AbstractRoute;

final class Index extends AbstractRoute
{
    public function method(): string
    {
        return HttpMethod::GET->value;
    }

    public function uri(): string
    {
        return 'comments';
    }

    public function handle()
    {

    }
}
