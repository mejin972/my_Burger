<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20211210113401 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE rang_user (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, condition_obtention VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE user ADD rang_user_id INT DEFAULT NULL');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D64963D6A5D3 FOREIGN KEY (rang_user_id) REFERENCES rang_user (id)');
        $this->addSql('CREATE INDEX IDX_8D93D64963D6A5D3 ON user (rang_user_id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D64963D6A5D3');
        $this->addSql('DROP TABLE rang_user');
        $this->addSql('DROP INDEX IDX_8D93D64963D6A5D3 ON user');
        $this->addSql('ALTER TABLE user DROP rang_user_id');
    }
}
