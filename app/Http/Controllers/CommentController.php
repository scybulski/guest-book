<?php

namespace App\Http\Controllers;

use App\Http\Requests\Comments\StoreRequest;
use App\Http\Requests\PaginatedIndexRequest;
use App\Http\Responses\Comments\CommentsIndex;
use App\Http\Responses\RedirectResponse;
use App\Repositories\CommentRepository;

class CommentController
{
    protected CommentRepository $comments;

    public function __construct()
    {
        $this->setUp();
    }

    protected function setUp(): void
    {
        $this->comments = new CommentRepository();
    }

    public function index(): void
    {
        $request = new PaginatedIndexRequest();

        $paginationValue = $request->getPaginationValue();

        $comments = $this->comments->index($paginationValue);

        (new CommentsIndex($comments))->render();
    }

    public function store(): void
    {
        $request = new StoreRequest();

        $commentDto = $request->toCommentDto();

        $this->comments->store($commentDto);

        (new RedirectResponse('/comments'))->render();
    }
}
