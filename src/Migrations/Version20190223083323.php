<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190223083323 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client ADD source_id INT DEFAULT NULL, CHANGE telephone description VARCHAR(255) DEFAULT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455953C1C61 FOREIGN KEY (source_id) REFERENCES lead_source (id)');
        $this->addSql('CREATE INDEX IDX_C7440455953C1C61 ON client (source_id)');
        $this->addSql('ALTER TABLE lead_source DROP FOREIGN KEY FK_22EB060F19EB6921');
        $this->addSql('DROP INDEX IDX_22EB060F19EB6921 ON lead_source');
        $this->addSql('ALTER TABLE lead_source DROP client_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455953C1C61');
        $this->addSql('DROP INDEX IDX_C7440455953C1C61 ON client');
        $this->addSql('ALTER TABLE client DROP source_id, CHANGE description telephone VARCHAR(255) DEFAULT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE lead_source ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lead_source ADD CONSTRAINT FK_22EB060F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_22EB060F19EB6921 ON lead_source (client_id)');
    }
}
