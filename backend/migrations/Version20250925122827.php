<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250925122827 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE pin (id SERIAL NOT NULL, compte_id INT NOT NULL, pin VARCHAR(6) NOT NULL, date_expiration TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_B5852DF3F2C56620 ON pin (compte_id)');
        $this->addSql('COMMENT ON COLUMN pin.date_expiration IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE pin ADD CONSTRAINT FK_B5852DF3F2C56620 FOREIGN KEY (compte_id) REFERENCES compte (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('ALTER TABLE pin DROP CONSTRAINT FK_B5852DF3F2C56620');
        $this->addSql('DROP TABLE pin');
    }
}
