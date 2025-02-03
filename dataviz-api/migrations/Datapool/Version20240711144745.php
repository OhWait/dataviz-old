<?php

declare(strict_types=1);

namespace DoctrineMigrations\Datapool;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240711144745 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create territoire.commune table for Municipality entity';
    }

    public function up(Schema $schema): void
    {
        // This migration runs on the "pool" entity manager
        $this->addSql('CREATE SCHEMA IF NOT EXISTS territoire');
        $this->addSql('
            CREATE TABLE territoire.commune (
                annee INT NOT NULL,
                typecom VARCHAR(4) NOT NULL,
                codgeo VARCHAR(5) NOT NULL,
                reg VARCHAR(2) DEFAULT NULL,
                dep VARCHAR(3) DEFAULT NULL,
                ctcd VARCHAR(4) DEFAULT NULL,
                arr VARCHAR(4) DEFAULT NULL,
                tncc VARCHAR(1) DEFAULT NULL,
                ncc VARCHAR(255) NOT NULL,
                nccenr VARCHAR(255) NOT NULL,
                libelle VARCHAR(255) NOT NULL,
                can VARCHAR(5) DEFAULT NULL,
                comparent VARCHAR(5) DEFAULT NULL,
                PRIMARY KEY (annee, codgeo)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS territoire.commune');
    }
}
