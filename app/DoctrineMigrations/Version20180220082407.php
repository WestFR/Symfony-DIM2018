<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20180220082407 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE s_shows CHANGE user_id user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE s_shows ADD CONSTRAINT FK_172DA9B3A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('CREATE INDEX IDX_172DA9B3A76ED395 ON s_shows (user_id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE s_shows DROP FOREIGN KEY FK_172DA9B3A76ED395');
        $this->addSql('DROP INDEX IDX_172DA9B3A76ED395 ON s_shows');
        $this->addSql('ALTER TABLE s_shows CHANGE user_id user_id INT NOT NULL');
    }
}
