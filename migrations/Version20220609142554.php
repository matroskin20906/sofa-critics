<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220609142554 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE film (id INT NOT NULL, name VARCHAR(40) NOT NULL, director VARCHAR(40) NOT NULL, actors VARCHAR(1024) NOT NULL, reviews JSON NOT NULL, keywords VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE "user" (id INT NOT NULL, username VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE app.film');
        $this->addSql('DROP TABLE app.my_user');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('CREATE TABLE app.film (id INT NOT NULL, name VARCHAR(40) NOT NULL, director VARCHAR(40) NOT NULL, actors VARCHAR(1024) NOT NULL, reviews JSON NOT NULL, keywords VARCHAR(1024) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE TABLE app.my_user (id INT NOT NULL, username VARCHAR(40) NOT NULL, password VARCHAR(255) NOT NULL, roles JSON NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE film');
        $this->addSql('DROP TABLE "user"');
    }
}
