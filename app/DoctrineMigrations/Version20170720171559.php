<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170720171559 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock_quantity CHANGE stock_id stock_id INT NOT NULL');
        $this->addSql('ALTER TABLE stock_quantity ADD CONSTRAINT FK_D0354274DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('CREATE INDEX IDX_D0354274DCD6110 ON stock_quantity (stock_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock_quantity DROP FOREIGN KEY FK_D0354274DCD6110');
        $this->addSql('DROP INDEX IDX_D0354274DCD6110 ON stock_quantity');
        $this->addSql('ALTER TABLE stock_quantity CHANGE stock_id stock_id VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci');
    }
}
