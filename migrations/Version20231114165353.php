<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231114165353 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_vehicule DROP FOREIGN KEY FK_F87ADDFF78218C2D');
        $this->addSql('DROP INDEX IDX_F87ADDFF78218C2D ON location_vehicule');
        $this->addSql('ALTER TABLE location_vehicule CHANGE vehicules matriculeVehicule INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location_vehicule ADD CONSTRAINT FK_F87ADDFF89372358 FOREIGN KEY (matriculeVehicule) REFERENCES vehicule (matricule)');
        $this->addSql('CREATE INDEX IDX_F87ADDFF89372358 ON location_vehicule (matriculeVehicule)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_vehicule DROP FOREIGN KEY FK_F87ADDFF89372358');
        $this->addSql('DROP INDEX IDX_F87ADDFF89372358 ON location_vehicule');
        $this->addSql('ALTER TABLE location_vehicule CHANGE matriculeVehicule vehicules INT DEFAULT NULL');
        $this->addSql('ALTER TABLE location_vehicule ADD CONSTRAINT FK_F87ADDFF78218C2D FOREIGN KEY (vehicules) REFERENCES vehicule (matricule)');
        $this->addSql('CREATE INDEX IDX_F87ADDFF78218C2D ON location_vehicule (vehicules)');
        $this->addSql('ALTER TABLE messenger_messages CHANGE delivered_at delivered_at DATETIME DEFAULT \'NULL\'');
    }
}
