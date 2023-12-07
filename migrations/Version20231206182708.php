<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231206182708 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agence (id INT AUTO_INCREMENT NOT NULL, assurance_id INT DEFAULT NULL, assurances_id INT DEFAULT NULL, nom_agence VARCHAR(255) NOT NULL, adresse VARCHAR(255) NOT NULL, telephone INT NOT NULL, email VARCHAR(255) NOT NULL, INDEX IDX_64C19AA9B288C3E3 (assurance_id), UNIQUE INDEX UNIQ_64C19AA9DEC08624 (assurances_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE assurance (id INT AUTO_INCREMENT NOT NULL, id_user INT NOT NULL, id_categorie INT NOT NULL, id_agence INT NOT NULL, passeport INT NOT NULL, destination VARCHAR(255) NOT NULL, date DATE NOT NULL, qr_code VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE bonplan (id INT AUTO_INCREMENT NOT NULL, type_bon_plan_id INT DEFAULT NULL, name_bon_plan VARCHAR(255) NOT NULL, rating DOUBLE PRECISION NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, avg_price DOUBLE PRECISION NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_A2FB7270659870C0 (type_bon_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE code_promo (id INT AUTO_INCREMENT NOT NULL, code VARCHAR(255) NOT NULL, valeur INT NOT NULL, datexpiration DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE facture (id_facture INT AUTO_INCREMENT NOT NULL, idreservation INT DEFAULT NULL, numfacture INT NOT NULL, montant_facture DOUBLE PRECISION NOT NULL, date_paiement VARCHAR(250) DEFAULT NULL, INDEX IDX_FE866410840939FA (idreservation), PRIMARY KEY(id_facture)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE location_vehicule (id_loc_vehicule INT AUTO_INCREMENT NOT NULL, cin_client_vehicule INT NOT NULL, duree_loc_vehicule VARCHAR(100) NOT NULL, pickup_vehicule VARCHAR(100) NOT NULL, return_vehicule VARCHAR(100) NOT NULL, montant_location INT NOT NULL, matriculeVehicule INT DEFAULT NULL, INDEX IDX_F87ADDFF89372358 (matriculeVehicule), PRIMARY KEY(id_loc_vehicule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offres (id_offres INT AUTO_INCREMENT NOT NULL, service INT DEFAULT NULL, destination VARCHAR(110) NOT NULL, debut DATE DEFAULT NULL, fin DATE DEFAULT NULL, prix INT NOT NULL, INDEX IDX_C6AC3544E19D9AD2 (service), PRIMARY KEY(id_offres)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, bonplan_id INT DEFAULT NULL, rating DOUBLE PRECISION NOT NULL, INDEX IDX_D88926225D69D22 (bonplan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reclamation (id INT AUTO_INCREMENT NOT NULL, remboursement_id INT DEFAULT NULL, type VARCHAR(255) NOT NULL, nom VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, datet_reclama DATETIME NOT NULL, UNIQUE INDEX UNIQ_CE606404F61EE8B (remboursement_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE remboursement (id INT AUTO_INCREMENT NOT NULL, reclamation_id INT DEFAULT NULL, montant_rembour INT NOT NULL, date_rembour DATETIME NOT NULL, id_rec INT NOT NULL, UNIQUE INDEX UNIQ_C0C0D9EF2D6BA2D9 (reclamation_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reservations (idreservation INT AUTO_INCREMENT NOT NULL, cinclient INT DEFAULT NULL, nomclient VARCHAR(150) NOT NULL, nombrepersonnes INT NOT NULL, dateDebut DATE DEFAULT NULL, dateFin DATE DEFAULT NULL, mode_paiement VARCHAR(250) NOT NULL, typehebergement VARCHAR(254) NOT NULL, typeactivite VARCHAR(254) NOT NULL, numtel INT NOT NULL, PRIMARY KEY(idreservation)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE reset_password_request (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, selector VARCHAR(20) NOT NULL, hashed_token VARCHAR(100) NOT NULL, requested_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', expires_at DATETIME NOT NULL COMMENT \'(DC2Type:datetime_immutable)\', INDEX IDX_7CE748AA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id_service INT AUTO_INCREMENT NOT NULL, nom_service VARCHAR(110) NOT NULL, description_service VARCHAR(110) NOT NULL, prix_service INT NOT NULL, PRIMARY KEY(id_service)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bon_plan (id INT AUTO_INCREMENT NOT NULL, nom_type_bon_plan VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles JSON NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, is_verified TINYINT(1) NOT NULL, name VARCHAR(255) NOT NULL, surename VARCHAR(255) NOT NULL, cin INT NOT NULL, UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (matricule INT NOT NULL, type_vehicule VARCHAR(50) NOT NULL, marque_vehicule VARCHAR(100) NOT NULL, PRIMARY KEY(matricule)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9B288C3E3 FOREIGN KEY (assurance_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9DEC08624 FOREIGN KEY (assurances_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE bonplan ADD CONSTRAINT FK_A2FB7270659870C0 FOREIGN KEY (type_bon_plan_id) REFERENCES type_bon_plan (id)');
        $this->addSql('ALTER TABLE facture ADD CONSTRAINT FK_FE866410840939FA FOREIGN KEY (idreservation) REFERENCES reservations (idreservation)');
        $this->addSql('ALTER TABLE location_vehicule ADD CONSTRAINT FK_F87ADDFF89372358 FOREIGN KEY (matriculeVehicule) REFERENCES vehicule (matricule)');
        $this->addSql('ALTER TABLE offres ADD CONSTRAINT FK_C6AC3544E19D9AD2 FOREIGN KEY (service) REFERENCES service (id_service)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926225D69D22 FOREIGN KEY (bonplan_id) REFERENCES bonplan (id)');
        $this->addSql('ALTER TABLE reclamation ADD CONSTRAINT FK_CE606404F61EE8B FOREIGN KEY (remboursement_id) REFERENCES remboursement (id)');
        $this->addSql('ALTER TABLE remboursement ADD CONSTRAINT FK_C0C0D9EF2D6BA2D9 FOREIGN KEY (reclamation_id) REFERENCES reclamation (id)');
        $this->addSql('ALTER TABLE reset_password_request ADD CONSTRAINT FK_7CE748AA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634DEC08624 FOREIGN KEY (assurances_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634ABB28E67 FOREIGN KEY (assurancee_id) REFERENCES assurance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634DEC08624');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634ABB28E67');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9B288C3E3');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9DEC08624');
        $this->addSql('ALTER TABLE bonplan DROP FOREIGN KEY FK_A2FB7270659870C0');
        $this->addSql('ALTER TABLE facture DROP FOREIGN KEY FK_FE866410840939FA');
        $this->addSql('ALTER TABLE location_vehicule DROP FOREIGN KEY FK_F87ADDFF89372358');
        $this->addSql('ALTER TABLE offres DROP FOREIGN KEY FK_C6AC3544E19D9AD2');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926225D69D22');
        $this->addSql('ALTER TABLE reclamation DROP FOREIGN KEY FK_CE606404F61EE8B');
        $this->addSql('ALTER TABLE remboursement DROP FOREIGN KEY FK_C0C0D9EF2D6BA2D9');
        $this->addSql('ALTER TABLE reset_password_request DROP FOREIGN KEY FK_7CE748AA76ED395');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE bonplan');
        $this->addSql('DROP TABLE code_promo');
        $this->addSql('DROP TABLE facture');
        $this->addSql('DROP TABLE location_vehicule');
        $this->addSql('DROP TABLE offres');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE reclamation');
        $this->addSql('DROP TABLE remboursement');
        $this->addSql('DROP TABLE reservations');
        $this->addSql('DROP TABLE reset_password_request');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE type_bon_plan');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vehicule');
    }
}
