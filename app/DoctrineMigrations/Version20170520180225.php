<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170520180225 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A368D710F7F');
        $this->addSql('DROP INDEX IDX_B12D4A368D710F7F ON inventory');
        $this->addSql('ALTER TABLE inventory CHANGE stores_id store_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A36B092A811 FOREIGN KEY (store_id) REFERENCES stores (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A36B092A811 ON inventory (store_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE inventory DROP FOREIGN KEY FK_B12D4A36B092A811');
        $this->addSql('DROP INDEX IDX_B12D4A36B092A811 ON inventory');
        $this->addSql('ALTER TABLE inventory CHANGE store_id stores_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE inventory ADD CONSTRAINT FK_B12D4A368D710F7F FOREIGN KEY (stores_id) REFERENCES stores (id)');
        $this->addSql('CREATE INDEX IDX_B12D4A368D710F7F ON inventory (stores_id)');
    }
}
