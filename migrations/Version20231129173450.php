<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231129173450 extends AbstractMigration
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
        $this->addSql('CREATE TABLE categorie (id INT AUTO_INCREMENT NOT NULL, assurances_id INT DEFAULT NULL, assurancee_id INT DEFAULT NULL, nom_categorie VARCHAR(255) NOT NULL, INDEX IDX_497DD634DEC08624 (assurances_id), UNIQUE INDEX UNIQ_497DD634ABB28E67 (assurancee_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9B288C3E3 FOREIGN KEY (assurance_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE agence ADD CONSTRAINT FK_64C19AA9DEC08624 FOREIGN KEY (assurances_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634DEC08624 FOREIGN KEY (assurances_id) REFERENCES assurance (id)');
        $this->addSql('ALTER TABLE categorie ADD CONSTRAINT FK_497DD634ABB28E67 FOREIGN KEY (assurancee_id) REFERENCES assurance (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9B288C3E3');
        $this->addSql('ALTER TABLE agence DROP FOREIGN KEY FK_64C19AA9DEC08624');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634DEC08624');
        $this->addSql('ALTER TABLE categorie DROP FOREIGN KEY FK_497DD634ABB28E67');
        $this->addSql('DROP TABLE agence');
        $this->addSql('DROP TABLE assurance');
        $this->addSql('DROP TABLE categorie');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
