<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241009063117 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Question comment';
    }

    public function up(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question ADD comment LONGTEXT DEFAULT NULL;');

    }

    public function down(Schema $schema): void
    {
        $this->addSql('ALTER TABLE question DROP comment');
    }
}
