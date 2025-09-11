<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250828070930 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE answer_summary (id INT AUTO_INCREMENT NOT NULL, area_id INT DEFAULT NULL, table_group_id INT DEFAULT NULL, level VARCHAR(255) NOT NULL, product VARCHAR(255) NOT NULL, answer VARCHAR(255) NOT NULL, period_start DATE NOT NULL COMMENT \'(DC2Type:date_immutable)\', period_end DATE DEFAULT NULL COMMENT \'(DC2Type:date_immutable)\', created_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', updated_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_8668A912BD0F409C (area_id), INDEX IDX_8668A9126EE9F797 (table_group_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE answer_summary ADD CONSTRAINT FK_8668A912BD0F409C FOREIGN KEY (area_id) REFERENCES area (id)');
        $this->addSql('ALTER TABLE answer_summary ADD CONSTRAINT FK_8668A9126EE9F797 FOREIGN KEY (table_group_id) REFERENCES table_group (id)');
        $this->addSql('ALTER TABLE question CHANGE available_answers available_answers JSON NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE answer_summary DROP FOREIGN KEY FK_8668A912BD0F409C');
        $this->addSql('ALTER TABLE answer_summary DROP FOREIGN KEY FK_8668A9126EE9F797');
        $this->addSql('DROP TABLE answer_summary');
        $this->addSql('ALTER TABLE question CHANGE available_answers available_answers JSON NOT NULL COLLATE `utf8mb4_bin`');
    }
}
