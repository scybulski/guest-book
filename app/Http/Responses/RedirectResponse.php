<?php

namespace App\Http\Responses;

class RedirectResponse implements ResponseContract
{
    public function __construct(
        protected string $url,
        protected int $httpStatus = 302,
    ) {
    }

    public function render(): void
    {
        http_response_code($this->httpStatus);

        header("Location: {$this->url}");
    }
}
