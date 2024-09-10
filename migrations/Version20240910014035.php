<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify it to your needs!
 */
final class Version20240910014035 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Ajouter les nouvelles colonnes et renommer 'adresse' en 'address'
        $this->addSql('ALTER TABLE user 
            ADD first_name VARCHAR(100) NOT NULL, 
            ADD last_name VARCHAR(100) NOT NULL, 
            ADD city VARCHAR(100) DEFAULT NULL, 
            ADD postal_code VARCHAR(20) DEFAULT NULL, 
            ADD country VARCHAR(100) DEFAULT NULL, 
            ADD phone VARCHAR(20) DEFAULT NULL, 
            CHANGE adresse address VARCHAR(255) DEFAULT NULL'
        );
    }

    public function down(Schema $schema): void
    {
        // Supprimer les nouvelles colonnes et restaurer les anciennes
        $this->addSql('ALTER TABLE user 
            DROP first_name, 
            DROP last_name, 
            DROP city, 
            DROP postal_code, 
            DROP country, 
            DROP phone, 
            CHANGE address adresse VARCHAR(255) DEFAULT NULL'
        );
    }
}
