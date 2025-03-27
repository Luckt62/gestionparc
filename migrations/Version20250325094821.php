<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250325094821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE affectation (id INT AUTO_INCREMENT NOT NULL, visiteur_id_id INT NOT NULL, vehicule_id_id INT NOT NULL, date_debut DATETIME NOT NULL, date_fin DATETIME NOT NULL, statut VARCHAR(50) DEFAULT NULL, INDEX IDX_F4DD61D392C6AC (visiteur_id_id), INDEX IDX_F4DD61D34F9D6605 (vehicule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE entretien (id INT AUTO_INCREMENT NOT NULL, vehicule_id_id INT NOT NULL, type VARCHAR(20) NOT NULL, date DATETIME NOT NULL, cout DOUBLE PRECISION NOT NULL, INDEX IDX_2B58D6DA4F9D6605 (vehicule_id_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `user` (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) NOT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:json)\', password VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_IDENTIFIER_EMAIL (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vehicule (id INT AUTO_INCREMENT NOT NULL, marque VARCHAR(50) NOT NULL, modele VARCHAR(30) NOT NULL, immatriculation VARCHAR(15) NOT NULL, kilometrage VARCHAR(9) NOT NULL, statu VARCHAR(15) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE visiteur_medical (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(50) NOT NULL, prenom VARCHAR(30) NOT NULL, email VARCHAR(50) NOT NULL, telephone VARCHAR(10) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D392C6AC FOREIGN KEY (visiteur_id_id) REFERENCES visiteur_medical (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D34F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DA4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D392C6AC');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D34F9D6605');
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY FK_2B58D6DA4F9D6605');
        $this->addSql('DROP TABLE affectation');
        $this->addSql('DROP TABLE entretien');
        $this->addSql('DROP TABLE `user`');
        $this->addSql('DROP TABLE vehicule');
        $this->addSql('DROP TABLE visiteur_medical');
    }
}
