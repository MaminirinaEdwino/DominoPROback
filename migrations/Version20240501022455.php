<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501022455 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_de_match DROP FOREIGN KEY FK_EFF5D39245ECA437');
        $this->addSql('DROP INDEX UNIQ_EFF5D39245ECA437 ON demande_de_match');
        $this->addSql('ALTER TABLE demande_de_match CHANGE table_dejeu_id table_de_jeu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_de_match ADD CONSTRAINT FK_EFF5D392110F04F0 FOREIGN KEY (table_de_jeu_id) REFERENCES table_de_jeu (id)');
        $this->addSql('CREATE INDEX IDX_EFF5D392110F04F0 ON demande_de_match (table_de_jeu_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_de_match DROP FOREIGN KEY FK_EFF5D392110F04F0');
        $this->addSql('DROP INDEX IDX_EFF5D392110F04F0 ON demande_de_match');
        $this->addSql('ALTER TABLE demande_de_match CHANGE table_de_jeu_id table_dejeu_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE demande_de_match ADD CONSTRAINT FK_EFF5D39245ECA437 FOREIGN KEY (table_dejeu_id) REFERENCES table_de_jeu (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_EFF5D39245ECA437 ON demande_de_match (table_dejeu_id)');
    }
}
