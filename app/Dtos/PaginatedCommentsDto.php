<?php

namespace App\Dtos;

class PaginatedCommentsDto
{
    public function __construct(
        public readonly array $comments,
        public readonly int $currentPage,
        public readonly int $totalPages,
        public readonly int $pageSize,
    ) {
    }
}
