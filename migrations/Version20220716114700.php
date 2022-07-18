<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220716114700 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create Agent entity and Add Mission.php and Country.php relation';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE agent (id INT AUTO_INCREMENT NOT NULL, country_id INT NOT NULL, mission_id INT NOT NULL, firstname VARCHAR(255) NOT NULL, lastname VARCHAR(255) NOT NULL, code_name VARCHAR(255) NOT NULL, birthday DATETIME NOT NULL, INDEX IDX_268B9C9DF92F3E70 (country_id), INDEX IDX_268B9C9DBE6CAE90 (mission_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('CREATE TABLE agent_skill (agent_id INT NOT NULL, skill_id INT NOT NULL, INDEX IDX_6793CC0F3414710B (agent_id), INDEX IDX_6793CC0F5585C142 (skill_id), PRIMARY KEY(agent_id, skill_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        $this->addSql('ALTER TABLE agent_skill ADD CONSTRAINT FK_6793CC0F3414710B FOREIGN KEY (agent_id) REFERENCES agent (id) ON DELETE CASCADE');

        $this->addSql('ALTER TABLE agent_skill ADD CONSTRAINT FK_6793CC0F5585C142 FOREIGN KEY (skill_id) REFERENCES skill (id) ON DELETE CASCADE');


        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DF92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');

        $this->addSql('ALTER TABLE agent ADD CONSTRAINT FK_268B9C9DBE6CAE90 FOREIGN KEY (mission_id) REFERENCES mission (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE agent');
    }
}
