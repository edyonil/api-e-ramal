<?php

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170608205613 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contato ADD ramal_telefone VARCHAR(255) NOT NULL, CHANGE created_at created_at timestamp default current_timestamp, CHANGE updated_at updated_at timestamp, CHANGE deleted_at deleted_at timestamp null');
        $this->addSql('ALTER TABLE usuario ADD nome VARCHAR(255) NOT NULL, CHANGE created_at created_at timestamp default current_timestamp, CHANGE updated_at updated_at timestamp, CHANGE deleted_at deleted_at timestamp null');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contato DROP ramal_telefone, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
        $this->addSql('ALTER TABLE usuario DROP nome, CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT NULL');
    }
}
