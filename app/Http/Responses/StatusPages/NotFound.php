<?php

namespace App\Http\Responses\StatusPages;

use App\Http\Facades\LatteEngineFacade;
use App\Http\Responses\ResponseContract;

final class NotFound implements ResponseContract
{
    public function render(): void
    {
        http_response_code(404);

        (new LatteEngineFacade())->render('404.latte');
    }
}
