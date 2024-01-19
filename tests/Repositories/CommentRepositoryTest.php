<?php

use App\DB\DBConnectionFactory;
use App\Dtos\CommentDto;
use App\Repositories\CommentRepository;
use App\Values\PaginationValue;
use PHPUnit\Framework\TestCase;

class CommentRepositoryTest extends TestCase
{
    protected ?PDO $dbConnection = null;

    public function setUp(): void
    {
        $this->dbConnection = DBConnectionFactory::getInstance()->getConnection();

        $this->dbConnection->query('DELETE FROM comments;')->execute();
    }

    /**
     * @test
     */
    public function storesComment(): void
    {
        $dto = new CommentDto(
            $name = 'Janusz',
            $comment = 'Good luck!',
        );

        $repository = new CommentRepository();

        $repository->store($dto);

        $pdoStatement = $this->dbConnection
            ->prepare("SELECT * FROM comments WHERE name = :name AND comment = :comment;");

        $pdoStatement->bindParam('name', $name);
        $pdoStatement->bindParam('comment', $comment);
        $pdoStatement->execute();

        $this->assertCount(
            1,
            $pdoStatement->fetchAll(),
        );
    }

    /**
     * @test
     */
    public function returnsPaginatedIndex(): void
    {
        $pdoStatement = $this->dbConnection
            ->prepare("INSERT INTO comments (name, comment) VALUES (:name, :comment);");

        for ($i = 0; $i < 12; $i++) {
            $name = "name {$i}";
            $pdoStatement->bindParam('name', $name);
            $comment = "comment {$i}";
            $pdoStatement->bindParam('comment', $comment);

            $pdoStatement->execute();
        }

        $repository = new CommentRepository();

        $paginatedComments = $repository->index(new PaginationValue(3, 5));

        $this->assertCount(2, $paginatedComments->comments);
        $this->assertEquals(3, $paginatedComments->currentPage);
        $this->assertEquals(3, $paginatedComments->totalPages);
    }
}
