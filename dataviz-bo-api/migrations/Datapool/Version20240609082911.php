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

        if ('test' === $_ENV['APP_ENV']) {
            $this->executeSqlFilesFromPath('/Data/*.sql');
        }
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
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
