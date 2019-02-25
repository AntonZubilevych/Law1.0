<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20190203135822 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, description VARCHAR(255) NOT NULL, amount INT NOT NULL, created_at DATETIME NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE price_list ADD service_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE price_list ADD CONSTRAINT FK_399A0AA2ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_399A0AA2ED5CA9E6 ON price_list (service_id)');
        $this->addSql('ALTER TABLE client ADD service_id INT NOT NULL');
        $this->addSql('ALTER TABLE client ADD CONSTRAINT FK_C7440455ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('CREATE INDEX IDX_C7440455ED5CA9E6 ON client (service_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE price_list DROP FOREIGN KEY FK_399A0AA2ED5CA9E6');
        $this->addSql('ALTER TABLE client DROP FOREIGN KEY FK_C7440455ED5CA9E6');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP INDEX IDX_C7440455ED5CA9E6 ON client');
        $this->addSql('ALTER TABLE client DROP service_id');
        $this->addSql('DROP INDEX IDX_399A0AA2ED5CA9E6 ON price_list');
        $this->addSql('ALTER TABLE price_list DROP service_id');
    }
}
