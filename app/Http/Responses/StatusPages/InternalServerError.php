<?php

namespace App\Http\Responses\StatusPages;

use App\Http\Facades\LatteEngineFacade;
use App\Http\Responses\ResponseContract;

final class InternalServerError implements ResponseContract
{
    public function render(): void
    {
        http_response_code(500);

        (new LatteEngineFacade())->render('500.latte');
    }
}
