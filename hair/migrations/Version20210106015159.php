<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210106015159 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX customerId ON booking');
        $this->addSql('ALTER TABLE booking ADD customer_id INT NOT NULL, ADD service_id INT NOT NULL, DROP customerId, DROP serviceId, CHANGE date date VARCHAR(255) NOT NULL, CHANGE hour hour VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE service ADD image VARCHAR(255) NOT NULL, CHANGE price price INT NOT NULL');
        $this->addSql('ALTER TABLE user CHANGE roles roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\'');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE booking ADD customerId INT NOT NULL, ADD serviceId INT NOT NULL, DROP customer_id, DROP service_id, CHANGE date date DATE NOT NULL, CHANGE hour hour TIME NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX customerId ON booking (customerId)');
        $this->addSql('ALTER TABLE service DROP image, CHANGE price price DOUBLE PRECISION NOT NULL');
        $this->addSql('ALTER TABLE `user` CHANGE roles roles VARCHAR(255) CHARACTER SET latin1 NOT NULL COLLATE `latin1_swedish_ci`');
    }
}
