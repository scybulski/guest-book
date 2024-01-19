<?php

namespace App\Dtos;

class CommentDto
{
    public function __construct(
        public readonly string $name,
        public readonly string $comment,
    ) {
    }
}
