<?php

namespace App\Repositories;

use App\DB\DBConnectionFactory;
use App\Dtos\CommentDto;
use App\Dtos\PaginatedCommentsDto;
use App\Values\PaginationValue;
use App\Models\Comment;

class CommentRepository
{
    public const DEFAULT_PAGE_SIZE = 25;

    public function store(CommentDto $commentDto): void
    {
        $comment = new Comment();

        $comment->name = $commentDto->name;
        $comment->comment = $commentDto->comment;

        $comment->save();
    }

    public function index(PaginationValue $paginationValue): PaginatedCommentsDto
    {
        $page = $paginationValue->page ?? 1;
        $pageSize = $paginationValue->pageSize ?? static::DEFAULT_PAGE_SIZE;

        $commentsDbResult = $this->queryPaginatedComments($page, $pageSize);

        $comments = array_map(
            fn (array $dbRow): Comment => Comment::fromDbRecord($dbRow),
            $commentsDbResult,
        );

        $totalPages = (int) ceil($this->queryCommentsCount() / $pageSize);

        return new PaginatedCommentsDto(
            comments: $comments,
            currentPage: $page,
            totalPages: $totalPages,
            pageSize: $pageSize,
        );
    }

    protected function queryPaginatedComments(
        int $page,
        int $pageSize,
    ): array {
        $offset = ($page - 1) * $pageSize;

        $table = (new Comment())->table();
        $sql = "SELECT * FROM {$table} LIMIT {$pageSize} OFFSET {$offset}";

        $dbConnection = DBConnectionFactory::getInstance()->getConnection();

        $dbStatement = $dbConnection->prepare($sql);
        $dbStatement->execute();

        return $dbStatement->fetchAll();
    }

    protected function queryCommentsCount(): int
    {
        $table = (new Comment())->table();
        $sql = "SELECT COUNT(*) AS comments_count FROM {$table}";

        $dbConnection = DBConnectionFactory::getInstance()->getConnection();

        $dbStatement = $dbConnection->prepare($sql);
        $dbStatement->execute();

        return intval($dbStatement->fetch()['comments_count']);
    }
}
