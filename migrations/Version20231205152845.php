<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205152845 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE facture (id_facture INT AUTO_INCREMENT NOT NULL, idreservation INT DEFAULT NULL, numfacture INT NOT NULL, montant_facture DOUBLE PRECISION NOT NULL, date_paiement VARCHAR(250) DEFAULT NULL, INDEX IDX_FE866410840939FA (idreservation), PRIMARY KEY(id_facture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (idreservation INT AUTO_INCREMENT NOT NULL, cinclient INT DEFAULT NULL, nomclient VARCHAR(150) NOT NULL, nombrepersonnes INT NOT NULL, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, mode_paiement VARCHAR(250) NOT NULL, typehebergement VARCHAR(254) NOT NULL, typeactivite VARCHAR(254) NOT NULL, numtel INT NOT NULL, PRIMARY KEY(idreservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410840939FA FOREIGN KEY (idreservation) REFERENCES reservations (idreservation)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410840939FA');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE reservations');
    }
}
