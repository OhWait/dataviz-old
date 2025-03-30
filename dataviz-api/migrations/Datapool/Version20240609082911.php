<?php

declare(strict_types=1);

namespace DoctrineMigrations\Datapool;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240609082911 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Import data tables';
    }

    public function up(Schema $schema): void
    {
        $this->abortIf(true !== $this->connection->getDatabasePlatform()->supportsSchemas(), 'Database doesn\'t support schema creation');

        $this->executeSqlFilesFromPath('/Script/*.sql');
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
        $this->addSql('
            CREATE TABLE territoire.departement (
                annee INT NOT NULL,
                dep VARCHAR(3) NOT NULL,
                reg VARCHAR(2) DEFAULT NULL,
                cheflieu VARCHAR(5) DEFAULT NULL,
                tncc VARCHAR(1) DEFAULT NULL,
                ncc VARCHAR(255) NOT NULL,
                nccenr VARCHAR(255) NOT NULL,
                libelle VARCHAR(255) NOT NULL,
                PRIMARY KEY (annee, dep)
            )
        ');
    }

    public function down(Schema $schema): void
    {
        $this->addSql('DROP TABLE IF EXISTS territoire.commune');
        $this->addSql('DROP TABLE IF EXISTS territoire.departement');
    }

    private function executeSqlFilesFromPath(string $path): void
    {
        foreach (glob(__DIR__.$path) as $file) {
            foreach (explode(';', file_get_contents($file)) as $sql) {
                if (!empty($sql)) {
                    $this->connection->executeQuery($sql);
                }
            }
        }
    }
}
