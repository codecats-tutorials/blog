<?php

namespace Application\Migrations;

use Doctrine\DBAL\Migrations\AbstractMigration;
use Doctrine\DBAL\Schema\Schema;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
class Version20140202164830 extends AbstractMigration
{
    public function up(Schema $schema)
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("CREATE TABLE Comment (id INT AUTO_INCREMENT NOT NULL, blog_id INT DEFAULT NULL, user VARCHAR(255) NOT NULL, comment LONGTEXT NOT NULL, approved TINYINT(1) NOT NULL, created DATETIME NOT NULL, updated DATETIME NOT NULL, INDEX IDX_5BC96BF0DAE07E97 (blog_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE = InnoDB");
        $this->addSql("ALTER TABLE Comment ADD CONSTRAINT FK_5BC96BF0DAE07E97 FOREIGN KEY (blog_id) REFERENCES Blog (id)");
    }

    public function down(Schema $schema)
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() != "mysql", "Migration can only be executed safely on 'mysql'.");
        
        $this->addSql("DROP TABLE Comment");
    }
}
