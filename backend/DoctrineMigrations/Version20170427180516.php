<?php

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170427180516 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contato (id INT AUTO_INCREMENT NOT NULL, usuario_id INT DEFAULT NULL, nome VARCHAR(255) NOT NULL, setor VARCHAR(255) NOT NULL, created_at timestamp default current_timestamp, updated_at timestamp, deleted_at timestamp, INDEX IDX_C384AB42DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contato ADD CONSTRAINT FK_C384AB42DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
        $this->addSql('ALTER TABLE usuario CHANGE created_at created_at timestamp default current_timestamp, CHANGE updated_at updated_at timestamp, CHANGE deleted_at deleted_at timestamp');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('DROP TABLE contato');
        $this->addSql('ALTER TABLE usuario CHANGE created_at created_at DATETIME DEFAULT CURRENT_TIMESTAMP NOT NULL, CHANGE updated_at updated_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL, CHANGE deleted_at deleted_at DATETIME DEFAULT \'0000-00-00 00:00:00\' NOT NULL');
    }
}
