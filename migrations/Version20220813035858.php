<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220813035858 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Add Slug method on Mission Entity';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission ADD slug VARCHAR(255) NOT NULL');
        $this->addSql('ALTER TABLE target CHANGE mission_id_id mission_id_id INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP slug');
        $this->addSql('ALTER TABLE target CHANGE mission_id_id mission_id_id INT NOT NULL');
    }
}
