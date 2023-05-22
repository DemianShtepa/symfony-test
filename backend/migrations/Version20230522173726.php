<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230522173726 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE project_milestone_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE project_milestone (id INT NOT NULL, project_id INT NOT NULL, title VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, deadline TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_639C54C0166D1F9C ON project_milestone (project_id)');
        $this->addSql('COMMENT ON COLUMN project_milestone.deadline IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE project_milestone ADD CONSTRAINT FK_639C54C0166D1F9C FOREIGN KEY (project_id) REFERENCES project (id) NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE project_milestone_id_seq CASCADE');
        $this->addSql('ALTER TABLE project_milestone DROP CONSTRAINT FK_639C54C0166D1F9C');
        $this->addSql('DROP TABLE project_milestone');
    }
}
