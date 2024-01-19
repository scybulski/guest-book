<?php

declare(strict_types=1);

namespace MyProject\Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240118103537 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE comments (
            id INT UNSIGNED NOT NULL AUTO_INCREMENT,
            name VARCHAR(255),
            comment VARCHAR(255),
            PRIMARY KEY (ID)
        );');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE comments');
    }
}
