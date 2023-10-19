<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20231019214110 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE medicine (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, name VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, species CLOB NOT NULL --(DC2Type:json)
        )');
        $this->addSql('CREATE TABLE prescription (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, appointment_id INTEGER NOT NULL, medicine_id INTEGER NOT NULL, date_start DATE NOT NULL, date_end DATE NOT NULL, quantity INTEGER NOT NULL, dosage VARCHAR(255) NOT NULL, CONSTRAINT FK_1FBFB8D9E5B533F9 FOREIGN KEY (appointment_id) REFERENCES appointment (id) NOT DEFERRABLE INITIALLY IMMEDIATE, CONSTRAINT FK_1FBFB8D92F7D140A FOREIGN KEY (medicine_id) REFERENCES medicine (id) NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D9E5B533F9 ON prescription (appointment_id)');
        $this->addSql('CREATE INDEX IDX_1FBFB8D92F7D140A ON prescription (medicine_id)');
        $this->addSql('CREATE TEMPORARY TABLE __temp__animal AS SELECT id, owner_id, name, birth, species FROM animal');
        $this->addSql('DROP TABLE animal');
        $this->addSql('CREATE TABLE animal (id INTEGER PRIMARY KEY AUTOINCREMENT NOT NULL, owner_id INTEGER NOT NULL, name VARCHAR(255) NOT NULL, birth DATE NOT NULL, species VARCHAR(255) NOT NULL, CONSTRAINT FK_6AAB231F7E3C61F9 FOREIGN KEY (owner_id) REFERENCES owner (id) ON UPDATE NO ACTION ON DELETE NO ACTION NOT DEFERRABLE INITIALLY IMMEDIATE)');
        $this->addSql('INSERT INTO animal (id, owner_id, name, birth, species) SELECT id, owner_id, name, birth, species FROM __temp__animal');
        $this->addSql('DROP TABLE __temp__animal');
        $this->addSql('CREATE INDEX IDX_6AAB231F7E3C61F9 ON animal (owner_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE medicine');
        $this->addSql('DROP TABLE prescription');
        $this->addSql('ALTER TABLE animal ADD COLUMN age INTEGER NOT NULL');
    }
}
