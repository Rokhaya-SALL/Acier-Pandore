<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240910014035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD first_name VARCHAR(100) NOT NULL, ADD last_name VARCHAR(100) NOT NULL, ADD city VARCHAR(100) DEFAULT NULL, ADD postal_code VARCHAR(20) DEFAULT NULL, ADD country VARCHAR(100) DEFAULT NULL, ADD phone VARCHAR(20) DEFAULT NULL, DROP prenom, DROP nom, DROP ville, DROP code_postal, DROP pays, DROP telephone, CHANGE adresse address VARCHAR(255) DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user ADD prenom VARCHAR(100) NOT NULL, ADD nom VARCHAR(100) NOT NULL, ADD ville VARCHAR(100) DEFAULT NULL, ADD code_postal VARCHAR(20) DEFAULT NULL, ADD pays VARCHAR(100) DEFAULT NULL, ADD telephone VARCHAR(20) DEFAULT NULL, DROP first_name, DROP last_name, DROP city, DROP postal_code, DROP country, DROP phone, CHANGE address adresse VARCHAR(255) DEFAULT NULL');
    }
}
