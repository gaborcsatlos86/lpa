<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250908113805 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_answer ADD answer_summary_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE question_answer ADD CONSTRAINT FK_DD80652D454F5C62 FOREIGN KEY (answer_summary_id) REFERENCES answer_summary (id)');
        $this->addSql('CREATE INDEX IDX_DD80652D454F5C62 ON question_answer (answer_summary_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE question_answer DROP FOREIGN KEY FK_DD80652D454F5C62');
        $this->addSql('DROP INDEX IDX_DD80652D454F5C62 ON question_answer');
        $this->addSql('ALTER TABLE question_answer DROP answer_summary_id');
    }
}
