<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220614151253 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP SEQUENCE yes_id_seq CASCADE');
        $this->addSql('DROP SEQUENCE user_user_identifier_seq CASCADE');
        $this->addSql('CREATE SEQUENCE app.review_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE review (id INT NOT NULL, author_id INT NOT NULL, title VARCHAR(255) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE yes');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SCHEMA public');
        $this->addSql('DROP SEQUENCE app.review_id_seq CASCADE');
        $this->addSql('CREATE SEQUENCE yes_id_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE user_user_identifier_seq INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE yes (id INT NOT NULL, no VARCHAR(40) NOT NULL, PRIMARY KEY(id))');
        $this->addSql('DROP TABLE review');
    }
}
