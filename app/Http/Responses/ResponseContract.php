<?php

namespace App\Http\Responses;

interface ResponseContract
{
    public function render(): void;
}
