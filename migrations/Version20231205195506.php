<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231205195506 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bonplan (id INT AUTO_INCREMENT NOT NULL, type_bon_plan_id INT DEFAULT NULL, name_bon_plan VARCHAR(255) NOT NULL, rating DOUBLE PRECISION NOT NULL, start_date DATE NOT NULL, end_date DATE NOT NULL, avg_price DOUBLE PRECISION NOT NULL, location VARCHAR(255) NOT NULL, INDEX IDX_A2FB7270659870C0 (type_bon_plan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, bonplan_id INT DEFAULT NULL, rating DOUBLE PRECISION NOT NULL, INDEX IDX_D88926225D69D22 (bonplan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type_bon_plan (id INT AUTO_INCREMENT NOT NULL, nom_type_bon_plan VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE bonplan ADD CONSTRAINT FK_A2FB7270659870C0 FOREIGN KEY (type_bon_plan_id) REFERENCES type_bon_plan (id)');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926225D69D22 FOREIGN KEY (bonplan_id) REFERENCES bonplan (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE bonplan DROP FOREIGN KEY FK_A2FB7270659870C0');
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926225D69D22');
        $this->addSql('DROP TABLE bonplan');
        $this->addSql('DROP TABLE rating');
        $this->addSql('DROP TABLE type_bon_plan');
    }
}
