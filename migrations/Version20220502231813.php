<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Class Version20220502231813
 * @package DoctrineMigrations
 */
final class Version20220502231813 extends AbstractMigration
{
    /**
     * @return string
     */
    public function getDescription(): string
    {
        return 'Create schema';
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function up(Schema $schema): void
    {

        if (!$schema->hasTable('customer')) {
            $sqlUpCustomer = <<<SQLcustomer
                CREATE TABLE `phone_book`.`customer` (
                  `id` INT NOT NULL AUTO_INCREMENT,
                  `firstname` VARCHAR(255) NOT NULL,
                  `lastname` VARCHAR(255) NOT NULL,
                  `address_information` VARCHAR(500) NOT NULL,
                  `phone_number` VARCHAR(20) NOT NULL,
                  `birthday` DATE NOT NULL,
                  `email_address` VARCHAR(45) NOT NULL,
                  `picture` VARCHAR(255) NULL,
                  `last_login` DATETIME NULL,
                  `gender` VARCHAR(1) NOT NULL,
                  `subscribed_to_newsletter` TINYINT(1) NOT NULL,
                  `is_active` TINYINT(1) NOT NULL,
                  `created_at` DATETIME NOT NULL,
                  `updated_At` DATETIME NULL,
                  PRIMARY KEY (`id`, `email_address`, `is_active`, `created_at`));
SQLcustomer;
            $this->addSql($sqlUpCustomer);
        } else {
            $this->write('Table customer already exists');
        }

        if (!$schema->hasTable('contact')) {
            $sqlUpContact = <<<SQLcontact
            CREATE TABLE `phone_book`.`contact` (
                  `id` INT NOT NULL AUTO_INCREMENT,
                  `firstname` VARCHAR(255) NOT NULL,
                  `lastname` VARCHAR(255) NOT NULL,
                  `address_information` VARCHAR(500) NOT NULL,
                  `phone_number` VARCHAR(255) NOT NULL,
                  `birthday` DATE NOT NULL,
                  `email_address` VARCHAR(255) NOT NULL,
                  `picture` VARCHAR(255) NULL,
                  `fk_customer_id` INT NOT NULL,
                  `created_at` DATETIME NOT NULL,
                  `updated_at` DATETIME NULL,
                  PRIMARY KEY (`id`));
SQLcontact;
            $this->addSql($sqlUpContact);
        } else {
            $this->write('Table contact already exists');
        }
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        if ($schema->hasTable('contact')) {
            $this->addSql('DROP TABLE `customer`');
        }

        if ($schema->hasTable('customer')) {
            $this->addSql('DROP TABLE `contact`');
        }
    }
}
