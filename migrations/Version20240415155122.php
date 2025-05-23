<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Migrace pro vytvoření tabulky notes
 */
final class Version20240415155122 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Vytvoření tabulky notes';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('CREATE TABLE notes (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255) NOT NULL,
            text LONGTEXT NOT NULL,
            priority VARCHAR(20) NOT NULL,
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE notes');
    }
} 