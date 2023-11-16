<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231116092711 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation ADD remboursement_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F61EE8B FOREIGN KEY (remboursement_id) REFERENCES remboursement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE606404F61EE8B ON reclamation (remboursement_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F61EE8B');
        $this->addSql('DROP INDEX UNIQ_CE606404F61EE8B ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP remboursement_id');
    }
}
