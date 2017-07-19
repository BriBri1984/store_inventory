<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170719203015 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE stock (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, stock INT NOT NULL, date DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE stock_quantity (id INT AUTO_INCREMENT NOT NULL, stock_id INT DEFAULT NULL, stock_quantity INT NOT NULL, INDEX IDX_D0354274DCD6110 (stock_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE stock_quantity ADD CONSTRAINT FK_D0354274DCD6110 FOREIGN KEY (stock_id) REFERENCES stock (id)');
        $this->addSql('DROP TABLE master_inventory');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE stock_quantity DROP FOREIGN KEY FK_D0354274DCD6110');
        $this->addSql('CREATE TABLE master_inventory (id INT AUTO_INCREMENT NOT NULL, product_name VARCHAR(255) NOT NULL COLLATE utf8_unicode_ci, cost DOUBLE PRECISION NOT NULL, quantity INT NOT NULL, date_ordered DATE NOT NULL, date_received DATE NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('DROP TABLE stock');
        $this->addSql('DROP TABLE stock_quantity');
    }
}
