<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190203140859 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price_list DROP FOREIGN KEY FK_399A0AA2ED5CA9E6');
        $this->addSql('DROP INDEX IDX_399A0AA2ED5CA9E6 ON price_list');
        $this->addSql('ALTER TABLE price_list DROP service_id, DROP string');
        $this->addSql('ALTER TABLE lead_source DROP FOREIGN KEY FK_22EB060F19EB6921');
        $this->addSql('DROP INDEX IDX_22EB060F19EB6921 ON lead_source');
        $this->addSql('ALTER TABLE lead_source DROP client_id');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE lead_source ADD client_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lead_source ADD CONSTRAINT FK_22EB060F19EB6921 FOREIGN KEY (client_id) REFERENCES client (id)');
        $this->addSql('CREATE INDEX IDX_22EB060F19EB6921 ON lead_source (client_id)');
        $this->addSql('ALTER TABLE price_list ADD service_id INT DEFAULT NULL, ADD string VARCHAR(255) NOT NULL COLLATE utf8mb4_unicode_ci');
        $this->addSql('ALTER TABLE price_list ADD CONSTRAINT FK_399A0AA2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_399A0AA2ED5CA9E6 ON price_list (service_id)');
    }
}
