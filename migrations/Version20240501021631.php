<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240501021631 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE demande_de_match (id INT AUTO_INCREMENT NOT NULL, demandeur_id INT DEFAULT NULL, cible_id INT DEFAULT NULL, table_dejeu_id INT DEFAULT NULL, choix_cible TINYINT(1) DEFAULT NULL, INDEX IDX_EFF5D39295A6EE59 (demandeur_id), INDEX IDX_EFF5D392A96E5E09 (cible_id), UNIQUE INDEX UNIQ_EFF5D39245ECA437 (table_dejeu_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demande_de_match ADD CONSTRAINT FK_EFF5D39295A6EE59 FOREIGN KEY (demandeur_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE demande_de_match ADD CONSTRAINT FK_EFF5D392A96E5E09 FOREIGN KEY (cible_id) REFERENCES joueur (id)');
        $this->addSql('ALTER TABLE demande_de_match ADD CONSTRAINT FK_EFF5D39245ECA437 FOREIGN KEY (table_dejeu_id) REFERENCES table_de_jeu (id)');
        $this->addSql('ALTER TABLE joueur ADD enligne TINYINT(1) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE demande_de_match DROP FOREIGN KEY FK_EFF5D39295A6EE59');
        $this->addSql('ALTER TABLE demande_de_match DROP FOREIGN KEY FK_EFF5D392A96E5E09');
        $this->addSql('ALTER TABLE demande_de_match DROP FOREIGN KEY FK_EFF5D39245ECA437');
        $this->addSql('DROP TABLE demande_de_match');
        $this->addSql('ALTER TABLE joueur DROP enligne');
    }
}
