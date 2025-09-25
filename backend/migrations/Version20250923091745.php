<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250923091745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE bureau (id SERIAL NOT NULL, nom VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE compte (id SERIAL NOT NULL, identifiant VARCHAR(50) NOT NULL, mot_de_passe VARCHAR(255) NOT NULL, derniere_connexion TIMESTAMP(0) WITHOUT TIME ZONE DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE fonction (id SERIAL NOT NULL, nom VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE metier (id SERIAL NOT NULL, nom VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE module (id SERIAL NOT NULL, nom VARCHAR(200) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE utilisateur (id SERIAL NOT NULL, compte_id INT NOT NULL, nom VARCHAR(255) DEFAULT NULL, prenom VARCHAR(255) DEFAULT NULL, mail_perso VARCHAR(255) DEFAULT NULL, mail_pro VARCHAR(255) DEFAULT NULL, telephone VARCHAR(15) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B389A1584E ON utilisateur (mail_perso)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B377AFF995 ON utilisateur (mail_pro)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_1D1C63B3F2C56620 ON utilisateur (compte_id)');
        $this->addSql('CREATE TABLE utilisateur_fonction (utilisateur_id INT NOT NULL, fonction_id INT NOT NULL, PRIMARY KEY(utilisateur_id, fonction_id))');
        $this->addSql('CREATE INDEX IDX_177B2C22FB88E14F ON utilisateur_fonction (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_177B2C2257889920 ON utilisateur_fonction (fonction_id)');
        $this->addSql('CREATE TABLE utilisateur_metier (utilisateur_id INT NOT NULL, metier_id INT NOT NULL, PRIMARY KEY(utilisateur_id, metier_id))');
        $this->addSql('CREATE INDEX IDX_300D3707FB88E14F ON utilisateur_metier (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_300D3707ED16FA20 ON utilisateur_metier (metier_id)');
        $this->addSql('CREATE TABLE utilisateur_bureau (utilisateur_id INT NOT NULL, bureau_id INT NOT NULL, PRIMARY KEY(utilisateur_id, bureau_id))');
        $this->addSql('CREATE INDEX IDX_77C2E44FFB88E14F ON utilisateur_bureau (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_77C2E44F32516FE2 ON utilisateur_bureau (bureau_id)');
        $this->addSql('CREATE TABLE utilisateur_module (utilisateur_id INT NOT NULL, module_id INT NOT NULL, PRIMARY KEY(utilisateur_id, module_id))');
        $this->addSql('CREATE INDEX IDX_6D891CA3FB88E14F ON utilisateur_module (utilisateur_id)');
        $this->addSql('CREATE INDEX IDX_6D891CA3AFC2B591 ON utilisateur_module (module_id)');
        $this->addSql('ALTER TABLE utilisateur ADD CONSTRAINT FK_1D1C63B3F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_fonction ADD CONSTRAINT FK_177B2C22FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_fonction ADD CONSTRAINT FK_177B2C2257889920 FOREIGN KEY (fonction_id) REFERENCES fonction (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_metier ADD CONSTRAINT FK_300D3707FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_metier ADD CONSTRAINT FK_300D3707ED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_bureau ADD CONSTRAINT FK_77C2E44FFB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_bureau ADD CONSTRAINT FK_77C2E44F32516FE2 FOREIGN KEY (bureau_id) REFERENCES bureau (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_module ADD CONSTRAINT FK_6D891CA3FB88E14F FOREIGN KEY (utilisateur_id) REFERENCES utilisateur (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE utilisateur_module ADD CONSTRAINT FK_6D891CA3AFC2B591 FOREIGN KEY (module_id) REFERENCES module (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE utilisateur DROP CONSTRAINT FK_1D1C63B3F2C56620');
        $this->addSql('ALTER TABLE utilisateur_fonction DROP CONSTRAINT FK_177B2C22FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_fonction DROP CONSTRAINT FK_177B2C2257889920');
        $this->addSql('ALTER TABLE utilisateur_metier DROP CONSTRAINT FK_300D3707FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_metier DROP CONSTRAINT FK_300D3707ED16FA20');
        $this->addSql('ALTER TABLE utilisateur_bureau DROP CONSTRAINT FK_77C2E44FFB88E14F');
        $this->addSql('ALTER TABLE utilisateur_bureau DROP CONSTRAINT FK_77C2E44F32516FE2');
        $this->addSql('ALTER TABLE utilisateur_module DROP CONSTRAINT FK_6D891CA3FB88E14F');
        $this->addSql('ALTER TABLE utilisateur_module DROP CONSTRAINT FK_6D891CA3AFC2B591');
        $this->addSql('DROP TABLE bureau');
        $this->addSql('DROP TABLE compte');
        $this->addSql('DROP TABLE fonction');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE module');
        $this->addSql('DROP TABLE utilisateur');
        $this->addSql('DROP TABLE utilisateur_fonction');
        $this->addSql('DROP TABLE utilisateur_metier');
        $this->addSql('DROP TABLE utilisateur_bureau');
        $this->addSql('DROP TABLE utilisateur_module');
    }
}
