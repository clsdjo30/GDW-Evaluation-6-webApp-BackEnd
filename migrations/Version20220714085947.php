<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220714085947 extends AbstractMigration
{
    public function getDescription(): string
    {
        return ' Create Mission, Country, Skill Entity ';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, nationality VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE mission (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, type_id INT NOT NULL, title VARCHAR(255) NOT NULL, code_name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, start_at DATETIME NOT NULL, end_at DATETIME DEFAULT NULL, INDEX IDX_9067F23CF92F3E70 (country_id), INDEX IDX_9067F23CC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE skill (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23CC54C8C93 FOREIGN KEY (type_id) REFERENCES skill (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CF92F3E70');
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23CC54C8C93');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE mission');
        $this->addSql('DROP TABLE skill');
    }
}
