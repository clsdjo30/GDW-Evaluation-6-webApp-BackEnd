<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220717053626 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Statute Entity with mission relation & Add relation between Agent and Skill';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent_skill (agent_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_6793CC0F3414710B (agent_id), INDEX IDX_6793CC0F5585C142 (skill_id), PRIMARY KEY(agent_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE statute (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE agent_skill ADD CONSTRAINT FK_6793CC0F3414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE agent_skill ADD CONSTRAINT FK_6793CC0F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE mission ADD status_id INT NOT NULL');
        $this->addSql('ALTER TABLE mission ADD CONSTRAINT FK_9067F23C6BF700BD FOREIGN KEY (status_id) REFERENCES statute (id)');
        $this->addSql('CREATE INDEX IDX_9067F23C6BF700BD ON mission (status_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE mission DROP FOREIGN KEY FK_9067F23C6BF700BD');
        $this->addSql('DROP TABLE agent_skill');
        $this->addSql('DROP TABLE statute');
        $this->addSql('DROP INDEX IDX_9067F23C6BF700BD ON mission');
        $this->addSql('ALTER TABLE mission DROP status_id');
    }
}
