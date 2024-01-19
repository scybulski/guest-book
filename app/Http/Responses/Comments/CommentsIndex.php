<?php

namespace App\Http\Responses\Comments;

use App\Dtos\PaginatedCommentsDto;
use App\Http\Facades\LatteEngineFacade;
use App\Http\Responses\ResponseContract;

final class CommentsIndex implements ResponseContract
{
    public function __construct(
        protected PaginatedCommentsDto $comments,
    ) {
    }

    public function render(): void
    {
        (new LatteEngineFacade())->render(
            'comments/index.latte',
            [
                'comments' => $this->comments->comments,
                'currentPage' => $this->comments->currentPage,
                'totalPages' => $this->comments->totalPages,
                'pageSize' => $this->comments->pageSize,
            ],
        );
    }
}
