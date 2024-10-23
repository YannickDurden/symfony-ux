<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241010151044 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE past_launch ADD rocket_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE past_launch ADD CONSTRAINT FK_575C8323C57537DF FOREIGN KEY (rocket_id) REFERENCES rocket (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('CREATE INDEX IDX_575C8323C57537DF ON past_launch (rocket_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE past_launch DROP CONSTRAINT FK_575C8323C57537DF');
        $this->addSql('DROP INDEX IDX_575C8323C57537DF');
        $this->addSql('ALTER TABLE past_launch DROP rocket_id');
    }
}
