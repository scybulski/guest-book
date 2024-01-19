<?php

namespace App\Values;

class PaginationValue
{
    public function __construct(
        public readonly ?int $page,
        public readonly ?int $pageSize,
    ) {
    }
}
