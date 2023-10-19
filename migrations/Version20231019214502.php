<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019214502 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE medicine ADD COLUMN stock INTEGER NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TEMPORARY TABLE __temp__medicine AS SELECT id, name, price, species FROM medicine');
        $this->addSql('DROP TABLE medicine');
        $this->addSql('CREATE TABLE medicine (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, species CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('INSERT INTO medicine (id, name, price, species) SELECT id, name, price, species FROM __temp__medicine');
        $this->addSql('DROP TABLE __temp__medicine');
    }
}
