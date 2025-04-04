<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250401093452 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D34F9D6605');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D392C6AC');
        $this->addSql('DROP INDEX IDX_F4DD61D392C6AC ON affectation');
        $this->addSql('DROP INDEX IDX_F4DD61D34F9D6605 ON affectation');
        $this->addSql('ALTER TABLE affectation ADD vehicule_id INT NOT NULL, ADD visiteur_id INT NOT NULL, DROP visiteur_id_id, DROP vehicule_id_id, DROP statut, CHANGE date_debut date_debut DATE NOT NULL, CHANGE date_fin date_fin DATE NOT NULL');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D34A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D37F72333D FOREIGN KEY (visiteur_id) REFERENCES visiteur_medical (id)');
        $this->addSql('CREATE INDEX IDX_F4DD61D34A4A3511 ON affectation (vehicule_id)');
        $this->addSql('CREATE INDEX IDX_F4DD61D37F72333D ON affectation (visiteur_id)');
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY FK_2B58D6DA4F9D6605');
        $this->addSql('DROP INDEX IDX_2B58D6DA4F9D6605 ON entretien');
        $this->addSql('ALTER TABLE entretien ADD piece_jointe VARCHAR(255) DEFAULT NULL, CHANGE type type VARCHAR(50) NOT NULL, CHANGE date date DATE NOT NULL, CHANGE vehicule_id_id vehicule_id INT NOT NULL');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DA4A4A3511 FOREIGN KEY (vehicule_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_2B58D6DA4A4A3511 ON entretien (vehicule_id)');
        $this->addSql('ALTER TABLE vehicule ADD statut VARCHAR(20) NOT NULL, DROP statu, CHANGE modele modele VARCHAR(50) NOT NULL, CHANGE kilometrage kilometrage INT NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_292FFF1DBE73422E ON vehicule (immatriculation)');
        $this->addSql('ALTER TABLE visiteur_medical ADD role VARCHAR(20) NOT NULL, CHANGE prenom prenom VARCHAR(50) NOT NULL, CHANGE email email VARCHAR(100) NOT NULL, CHANGE telephone telephone VARCHAR(20) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_E523993CE7927C74 ON visiteur_medical (email)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE entretien DROP FOREIGN KEY FK_2B58D6DA4A4A3511');
        $this->addSql('DROP INDEX IDX_2B58D6DA4A4A3511 ON entretien');
        $this->addSql('ALTER TABLE entretien DROP piece_jointe, CHANGE type type VARCHAR(20) NOT NULL, CHANGE date date DATETIME NOT NULL, CHANGE vehicule_id vehicule_id_id INT NOT NULL');
        $this->addSql('ALTER TABLE entretien ADD CONSTRAINT FK_2B58D6DA4F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('CREATE INDEX IDX_2B58D6DA4F9D6605 ON entretien (vehicule_id_id)');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D34A4A3511');
        $this->addSql('ALTER TABLE affectation DROP FOREIGN KEY FK_F4DD61D37F72333D');
        $this->addSql('DROP INDEX IDX_F4DD61D34A4A3511 ON affectation');
        $this->addSql('DROP INDEX IDX_F4DD61D37F72333D ON affectation');
        $this->addSql('ALTER TABLE affectation ADD visiteur_id_id INT NOT NULL, ADD vehicule_id_id INT NOT NULL, ADD statut VARCHAR(50) DEFAULT NULL, DROP vehicule_id, DROP visiteur_id, CHANGE date_debut date_debut DATETIME NOT NULL, CHANGE date_fin date_fin DATETIME NOT NULL');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D34F9D6605 FOREIGN KEY (vehicule_id_id) REFERENCES vehicule (id)');
        $this->addSql('ALTER TABLE affectation ADD CONSTRAINT FK_F4DD61D392C6AC FOREIGN KEY (visiteur_id_id) REFERENCES visiteur_medical (id)');
        $this->addSql('CREATE INDEX IDX_F4DD61D392C6AC ON affectation (visiteur_id_id)');
        $this->addSql('CREATE INDEX IDX_F4DD61D34F9D6605 ON affectation (vehicule_id_id)');
        $this->addSql('DROP INDEX UNIQ_E523993CE7927C74 ON visiteur_medical');
        $this->addSql('ALTER TABLE visiteur_medical DROP role, CHANGE prenom prenom VARCHAR(30) NOT NULL, CHANGE email email VARCHAR(50) NOT NULL, CHANGE telephone telephone VARCHAR(10) NOT NULL');
        $this->addSql('DROP INDEX UNIQ_292FFF1DBE73422E ON vehicule');
        $this->addSql('ALTER TABLE vehicule ADD statu VARCHAR(15) NOT NULL, DROP statut, CHANGE modele modele VARCHAR(30) NOT NULL, CHANGE kilometrage kilometrage VARCHAR(9) NOT NULL');
    }
}
