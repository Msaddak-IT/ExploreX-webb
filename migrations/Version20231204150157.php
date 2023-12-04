<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231204150157 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY assurance_ibfk_2');
        $this->addSql('ALTER TABLE assurance DROP FOREIGN KEY assurance_ibfk_1');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY facture_ibfk_1');
        $this->addSql('ALTER TABLE location_vehicule DROP FOREIGN KEY location_vehicule_ibfk_1');
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY offres_ibfk_1');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE bonplan');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE code_promo');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE location_vehicule');
        $this->addSql('DROP TABLE offres');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE typebonplan');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('ALTER TABLE reclamation ADD remboursement_id INT DEFAULT NULL, CHANGE type type VARCHAR(255) NOT NULL, CHANGE nom nom VARCHAR(255) NOT NULL, CHANGE description description VARCHAR(255) NOT NULL, CHANGE date_reclama datet_reclama DATETIME NOT NULL');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F61EE8B FOREIGN KEY (remboursement_id) REFERENCES remboursement (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_CE606404F61EE8B ON reclamation (remboursement_id)');
        $this->addSql('ALTER TABLE remboursement MODIFY id_rembour INT NOT NULL');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY fk_remboursement1_reclamation');
        $this->addSql('DROP INDEX fk_remboursement1_reclamation ON remboursement');
        $this->addSql('DROP INDEX `primary` ON remboursement');
        $this->addSql('ALTER TABLE remboursement ADD reclamation_id INT DEFAULT NULL, DROP Motif_rembour, CHANGE id_rembour id INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EF2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_C0C0D9EF2D6BA2D9 ON remboursement (reclamation_id)');
        $this->addSql('ALTER TABLE remboursement ADD PRIMARY KEY (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, nomAgence VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, adresse VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, telephone INT NOT NULL, email VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, idUser INT NOT NULL, idCategorie INT NOT NULL, idAgence INT NOT NULL, passeport INT NOT NULL, destination VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, date DATE NOT NULL, INDEX assurance_ibfk_1 (idAgence), INDEX assurance_ibfk_2 (idCategorie), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE bonplan (idBonPlan INT AUTO_INCREMENT NOT NULL, nameBonPlan VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, rating DOUBLE PRECISION NOT NULL, startDate DATE NOT NULL, endDate DATE NOT NULL, avgPrice DOUBLE PRECISION NOT NULL, fk_idTypeBonPlan INT DEFAULT NULL, INDEX fk_idTypeBonPlan (fk_idTypeBonPlan), PRIMARY KEY(idBonPlan)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, nomCategorie VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE code_promo (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, valeur INT NOT NULL, datexpiration DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE facture (id_facture INT AUTO_INCREMENT NOT NULL, idreservation INT NOT NULL, numfacture INT NOT NULL, montant_facture DOUBLE PRECISION NOT NULL, date_paiement VARCHAR(254) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, INDEX numRes (idreservation), PRIMARY KEY(id_facture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE location_vehicule (id_loc_vehicule INT AUTO_INCREMENT NOT NULL, matriculeVehicule INT NOT NULL, cin_client_vehicule INT NOT NULL, duree_loc_vehicule VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, pickup_vehicule VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, return_vehicule VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, montant_location INT NOT NULL, INDEX matriculeVehicule (matriculeVehicule), PRIMARY KEY(id_loc_vehicule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE offres (id_offres INT AUTO_INCREMENT NOT NULL, service INT NOT NULL, destination VARCHAR(110) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, debut DATE NOT NULL, fin DATE NOT NULL, prix INT NOT NULL, INDEX service (service), PRIMARY KEY(id_offres)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reservations (idReservation INT AUTO_INCREMENT NOT NULL, cinclient INT NOT NULL, nomclient VARCHAR(254) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, nombrePersonnes INT NOT NULL, dateDebut DATE NOT NULL, dateFin DATE NOT NULL, mode_paiement VARCHAR(254) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, typeHebergement VARCHAR(254) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, typeActivite VARCHAR(254) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, numtel INT NOT NULL, PRIMARY KEY(idReservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, hashed_token VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE service (id_service INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(250) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, description_service TEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, prix_service INT NOT NULL, PRIMARY KEY(id_service)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE typebonplan (idTypeBonPlan INT AUTO_INCREMENT NOT NULL, locationBonPlan VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, travelStyle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(idTypeBonPlan)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, is_verified TINYINT(1) NOT NULL, name VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, surename VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cin INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE vehicule (matricule INT NOT NULL, type_vehicule VARCHAR(50) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, marque_vehicule VARCHAR(100) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_general_ci`, PRIMARY KEY(matricule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_general_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT assurance_ibfk_2 FOREIGN KEY (idCategorie) REFERENCES categorie (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE assurance ADD CONSTRAINT assurance_ibfk_1 FOREIGN KEY (idAgence) REFERENCES agence (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT facture_ibfk_1 FOREIGN KEY (idreservation) REFERENCES reservations (idReservation) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE location_vehicule ADD CONSTRAINT location_vehicule_ibfk_1 FOREIGN KEY (matriculeVehicule) REFERENCES vehicule (matricule) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT offres_ibfk_1 FOREIGN KEY (service) REFERENCES service (id_service) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F61EE8B');
        $this->addSql('DROP INDEX UNIQ_CE606404F61EE8B ON reclamation');
        $this->addSql('ALTER TABLE reclamation DROP remboursement_id, CHANGE type type VARCHAR(222) NOT NULL, CHANGE nom nom VARCHAR(222) NOT NULL, CHANGE description description VARCHAR(222) NOT NULL, CHANGE datet_reclama date_reclama DATETIME NOT NULL');
        $this->addSql('ALTER TABLE remboursement MODIFY id INT NOT NULL');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EF2D6BA2D9');
        $this->addSql('DROP INDEX UNIQ_C0C0D9EF2D6BA2D9 ON remboursement');
        $this->addSql('DROP INDEX `PRIMARY` ON remboursement');
        $this->addSql('ALTER TABLE remboursement ADD Motif_rembour VARCHAR(244) NOT NULL, DROP reclamation_id, CHANGE id id_rembour INT AUTO_INCREMENT NOT NULL');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT fk_remboursement1_reclamation FOREIGN KEY (id_rec) REFERENCES reclamation (id) ON UPDATE CASCADE ON DELETE CASCADE');
        $this->addSql('CREATE INDEX fk_remboursement1_reclamation ON remboursement (id_rec)');
        $this->addSql('ALTER TABLE remboursement ADD PRIMARY KEY (id_rembour)');
    }
}
