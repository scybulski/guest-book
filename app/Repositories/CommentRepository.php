<?php

namespace App\Repositories;

use App\DB\DBConnectionFactory;
use App\Dtos\CommentDto;
use App\Models\Comment;

class CommentRepository
{
    public function store(CommentDto $commentDto): void
    {
        $comment = new Comment();

        $comment->name = $commentDto->name;
        $comment->comment = $commentDto->comment;

        $comment->save();
    }

    public function index(int $page = 1, int $pageSize = 25): array
    {
        $dbConnection = DBConnectionFactory::getInstance()->getConnection();

        $table = (new Comment())->table();
        $offset = ($page - 1) * $pageSize;

        $sql = "SELECT * FROM {$table} LIMIT {$pageSize} OFFSET {$offset}";

        $dbStatement = $dbConnection->prepare($sql);
        $dbStatement->execute();

        $dbResult = $dbStatement->fetchAll();

        return array_map(
            fn (array $dbRow): Comment => Comment::fromDbRecord($dbRow),
            $dbResult,
        );
    }
}
