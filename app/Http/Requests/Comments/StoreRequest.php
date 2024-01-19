<?php

namespace App\Http\Requests\Comments;

use App\Dtos\CommentDto;
use App\Http\Requests\Request;

class StoreRequest implements Request
{
    public function getData(): array
    {
        return [
            'name' => $_POST['name'] ?? null,
            'comment' => $_POST['comment'] ?? null,
        ];
    }

    public function toCommentDto(): CommentDto
    {
        return new CommentDto(
            ...$this->getData()
        );
    }
}
