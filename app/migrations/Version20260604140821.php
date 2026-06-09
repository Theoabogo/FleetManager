<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20260604140821 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment ADD driver_id INT NOT NULL');
        $this->addSql('ALTER TABLE assignment ADD CONSTRAINT FK_30C544BAC3423909 FOREIGN KEY (driver_id) REFERENCES driver (id)');
        $this->addSql('CREATE INDEX IDX_30C544BAC3423909 ON assignment (driver_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE assignment DROP FOREIGN KEY FK_30C544BAC3423909');
        $this->addSql('DROP INDEX IDX_30C544BAC3423909 ON assignment');
        $this->addSql('ALTER TABLE assignment DROP driver_id');
    }
}
