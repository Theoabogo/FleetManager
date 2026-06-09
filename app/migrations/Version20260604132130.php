<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260604132130 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment ADD comment VARCHAR(500) DEFAULT NULL, ADD vehicle_id INT NOT NULL, CHANGE returned_at returned_at INT DEFAULT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BA545317D1 FOREIGN KEY (vehicle_id) REFERENCES vehicle (id)');
        $this->addSql('CREATE INDEX IDX_30C544BA545317D1 ON assignment (vehicle_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BA545317D1');
        $this->addSql('DROP INDEX IDX_30C544BA545317D1 ON assignment');
        $this->addSql('ALTER TABLE assignment DROP comment, DROP vehicle_id, CHANGE returned_at returned_at INT NOT NULL');
    }
}
