<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260604125432 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY `FK_30C544BA545317D1`');
        $this->addSql('DROP INDEX IDX_30C544BA545317D1 ON assignment');
        $this->addSql('ALTER TABLE assignment ADD assigned_at DATETIME NOT NULL, CHANGE vehicle_id returned_at INT NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP assigned_at, CHANGE returned_at vehicle_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT `FK_30C544BA545317D1` FOREIGN KEY (vehicle_id) REFERENCES driver (id) ON UPDATE NO ACTION ON DELETE NO ACTION');
        $this->addSql('CREATE INDEX IDX_30C544BA545317D1 ON assignment (vehicle_id)');
    }
}
