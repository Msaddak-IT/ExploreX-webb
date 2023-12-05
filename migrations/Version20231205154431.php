<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205154431 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE location_vehicule (id_loc_vehicule INT AUTO_INCREMENT NOT NULL, cin_client_vehicule INT NOT NULL, duree_loc_vehicule VARCHAR(100) NOT NULL, pickup_vehicule VARCHAR(100) NOT NULL, return_vehicule VARCHAR(100) NOT NULL, montant_location INT NOT NULL, matriculeVehicule INT DEFAULT NULL, INDEX IDX_F87ADDFF89372358 (matriculeVehicule), PRIMARY KEY(id_loc_vehicule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (matricule INT NOT NULL, type_vehicule VARCHAR(50) NOT NULL, marque_vehicule VARCHAR(100) NOT NULL, PRIMARY KEY(matricule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE location_vehicule ADD CONSTRAINT FK_F87ADDFF89372358 FOREIGN KEY (matriculeVehicule) REFERENCES vehicule (matricule)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE location_vehicule DROP FOREIGN KEY FK_F87ADDFF89372358');
        $this->addSql('DROP TABLE location_vehicule');
        $this->addSql('DROP TABLE vehicule');
    }
}
