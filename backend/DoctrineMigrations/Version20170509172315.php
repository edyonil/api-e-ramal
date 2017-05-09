<?php

namespace App\DoctrineMigrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20170509172315 extends AbstractMigration
{
    /**
     * @param Schema $schema
     */
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE contato (id INT AUTO_INCREMENT NOT NULL, usuario_id INT NOT NULL, nome VARCHAR(255) NOT NULL, setor VARCHAR(255) NOT NULL, created_at timestamp default current_timestamp, updated_at timestamp, deleted_at timestamp null, INDEX IDX_C384AB42DB38439E (usuario_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('CREATE TABLE usuario (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(255) NOT NULL, ativo TINYINT(1) DEFAULT \'0\' NOT NULL, primeiro_acesso TINYINT(1) DEFAULT \'1\' NOT NULL, password VARCHAR(255) NOT NULL, compartilhar_contatos TINYINT(1) DEFAULT \'1\' NOT NULL, created_at timestamp default current_timestamp, updated_at timestamp, deleted_at timestamp null, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB');
        $this->addSql('ALTER TABLE contato ADD CONSTRAINT FK_C384AB42DB38439E FOREIGN KEY (usuario_id) REFERENCES usuario (id)');
    }

    /**
     * @param Schema $schema
     */
    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE contato DROP FOREIGN KEY FK_C384AB42DB38439E');
        $this->addSql('DROP TABLE contato');
        $this->addSql('DROP TABLE usuario');
    }
}
