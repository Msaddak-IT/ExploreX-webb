<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231127171614 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rating (id INT AUTO_INCREMENT NOT NULL, bonplan_id INT DEFAULT NULL, id_bon_plan INT NOT NULL, rating DOUBLE PRECISION NOT NULL, UNIQUE INDEX UNIQ_D88926225D69D22 (bonplan_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE rating ADD CONSTRAINT FK_D88926225D69D22 FOREIGN KEY (bonplan_id) REFERENCES bonplan (id)');
        $this->addSql('ALTER TABLE bonplan DROP rating');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE rating DROP FOREIGN KEY FK_D88926225D69D22');
        $this->addSql('DROP TABLE rating');
        $this->addSql('ALTER TABLE bonplan ADD rating DOUBLE PRECISION NOT NULL');
    }
}
