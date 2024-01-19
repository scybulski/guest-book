<?php

namespace App\Http\Routes\Comments;

use App\Http\Controllers\CommentController;
use App\Http\Enums\HttpMethod;
use App\Http\Routes\AbstractRoute;

final class Store extends AbstractRoute
{
    public function method(): string
    {
        return HttpMethod::POST->value;
    }

    public function uri(): string
    {
        return 'comments';
    }

    public function handle(): void
    {
        $commentController = (new CommentController());

        $commentController->store();
    }
}
