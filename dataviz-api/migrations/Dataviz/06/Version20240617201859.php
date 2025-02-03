<?php

declare(strict_types=1);

namespace DoctrineMigrations\Dataviz;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20240617201859 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE meta_column_id_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE meta_row_id_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE data_entry (slug VARCHAR(255) NOT NULL, dataset_id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, schema_name VARCHAR(255) NOT NULL, table_name VARCHAR(255) NOT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE UNIQUE INDEX schema_table_unique_idx ON data_entry (schema_name, table_name)');
        $this->addSql('CREATE INDEX IDX_659E51EFD47C2D1B ON data_entry (dataset_id)');
        $this->addSql('CREATE TABLE dataset (slug VARCHAR(255) NOT NULL, provider_id VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, title VARCHAR(255) NOT NULL, short_title VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, perimeter TEXT NOT NULL, granularity VARCHAR(255) NOT NULL, update_frequency VARCHAR(255) DEFAULT NULL, update_period VARCHAR(255) DEFAULT NULL, security VARCHAR(255) NOT NULL, language VARCHAR(255) DEFAULT NULL, data_created_at DATE DEFAULT NULL, data_updated_at DATE DEFAULT NULL, data_provider VARCHAR(255) DEFAULT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE INDEX IDX_B7A041D0A53A8AA ON dataset (provider_id)');
        $this->addSql('CREATE TABLE theme_dataset (dataset VARCHAR(255) NOT NULL, theme VARCHAR(255) NOT NULL, PRIMARY KEY(dataset, theme))');
        $this->addSql('CREATE INDEX IDX_EEC344F3B7A041D0 ON theme_dataset (dataset)');
        $this->addSql('CREATE INDEX IDX_EEC344F39775E708 ON theme_dataset (theme)');
        $this->addSql('CREATE TABLE meta_column (id INT NOT NULL, data_entry_id VARCHAR(255) NOT NULL, column_name VARCHAR(255) NOT NULL, nullable BOOLEAN NOT NULL, data_type VARCHAR(255) NOT NULL, character_maximum_length INT DEFAULT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_6F0B289870E8809E ON meta_column (data_entry_id)');
        $this->addSql('CREATE TABLE meta_row (id INT NOT NULL, meta_column_id INT NOT NULL, value VARCHAR(255) NOT NULL, label VARCHAR(255) DEFAULT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_2BBC28565FCE5B35 ON meta_row (meta_column_id)');
        $this->addSql('CREATE TABLE provider (slug VARCHAR(255) NOT NULL, created_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated_at TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, name VARCHAR(255) NOT NULL, acronym VARCHAR(255) DEFAULT NULL, description TEXT DEFAULT NULL, PRIMARY KEY(slug))');
        $this->addSql('CREATE TABLE theme (slug VARCHAR(255) NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(slug))');
        $this->addSql('ALTER TABLE data_entry ADD CONSTRAINT FK_659E51EFD47C2D1B FOREIGN KEY (dataset_id) REFERENCES dataset (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE dataset ADD CONSTRAINT FK_B7A041D0A53A8AA FOREIGN KEY (provider_id) REFERENCES provider (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_dataset ADD CONSTRAINT FK_EEC344F3B7A041D0 FOREIGN KEY (dataset) REFERENCES dataset (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE theme_dataset ADD CONSTRAINT FK_EEC344F39775E708 FOREIGN KEY (theme) REFERENCES theme (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meta_column ADD CONSTRAINT FK_6F0B289870E8809E FOREIGN KEY (data_entry_id) REFERENCES data_entry (slug) NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE meta_row ADD CONSTRAINT FK_2BBC28565FCE5B35 FOREIGN KEY (meta_column_id) REFERENCES meta_column (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE meta_column_id_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE meta_row_id_id_seq CASCADE');
        $this->addSql('DROP INDEX schema_table_unique_idx');
        $this->addSql('ALTER TABLE data_entry DROP CONSTRAINT FK_659E51EFD47C2D1B');
        $this->addSql('ALTER TABLE dataset DROP CONSTRAINT FK_B7A041D0A53A8AA');
        $this->addSql('ALTER TABLE theme_dataset DROP CONSTRAINT FK_EEC344F3B7A041D0');
        $this->addSql('ALTER TABLE theme_dataset DROP CONSTRAINT FK_EEC344F39775E708');
        $this->addSql('ALTER TABLE meta_column DROP CONSTRAINT FK_6F0B289870E8809E');
        $this->addSql('ALTER TABLE meta_row DROP CONSTRAINT FK_2BBC28565FCE5B35');
        $this->addSql('DROP TABLE data_entry');
        $this->addSql('DROP TABLE dataset');
        $this->addSql('DROP TABLE theme_dataset');
        $this->addSql('DROP TABLE meta_column');
        $this->addSql('DROP TABLE meta_row');
        $this->addSql('DROP TABLE provider');
        $this->addSql('DROP TABLE theme');
    }
}
