<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;


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
        $sqlUp = <<<SQL
            CREATE TABLE `phone_book`.`contact` (
                  `id` INT NOT NULL AUTO_INCREMENT,
                  `firstname` VARCHAR(255) NOT NULL,
                  `lastname` VARCHAR(255) NOT NULL,
                  `address_information` VARCHAR(500) NOT NULL,
                  `birthday` DATE NOT NULL,
                  `emailAddress` VARCHAR(45) NOT NULL,
                  `picture` VARCHAR(45) NULL,
                  `created_at` DATETIME NOT NULL,
                  `updated_at` DATETIME NULL,
                  PRIMARY KEY (`id`));
SQL;
        $this->addSql($sqlUp);
    }

    /**
     * @param Schema $schema
     * @return void
     */
    public function down(Schema $schema): void
    {
        $sqlDown = <<<SQL
                DROP DATABASE `phone_book`; 
                DROP TABLE `contact`
SQL;
        $this->addSql($sqlDown);
    }
}
