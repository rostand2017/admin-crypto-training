<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20201006072547 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE admin ADD roles JSON NOT NULL, CHANGE password password VARCHAR(255) NOT NULL');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_880E0D76E7927C74 ON admin (email)');
        $this->addSql('ALTER TABLE course CHANGE Admin Admin INT DEFAULT NULL, CHANGE Category Category INT DEFAULT NULL');
        $this->addSql('ALTER TABLE lesson CHANGE Module Module INT DEFAULT NULL');
        $this->addSql('ALTER TABLE module CHANGE Course Course INT DEFAULT NULL');
        $this->addSql('ALTER TABLE section CHANGE Lesson Lesson INT DEFAULT NULL');
        $this->addSql('ALTER TABLE subcription CHANGE Course Course INT DEFAULT NULL, CHANGE User User INT DEFAULT NULL');
        $this->addSql('ALTER TABLE supportfiles CHANGE Lesson Lesson INT DEFAULT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP INDEX UNIQ_880E0D76E7927C74 ON admin');
        $this->addSql('ALTER TABLE admin DROP roles, CHANGE password password VARCHAR(254) CHARACTER SET utf8 NOT NULL COLLATE `utf8_general_ci`');
        $this->addSql('ALTER TABLE course CHANGE Category Category INT NOT NULL, CHANGE Admin Admin INT NOT NULL');
        $this->addSql('ALTER TABLE lesson CHANGE Module Module INT NOT NULL');
        $this->addSql('ALTER TABLE module CHANGE Course Course INT NOT NULL');
        $this->addSql('ALTER TABLE section CHANGE Lesson Lesson INT NOT NULL');
        $this->addSql('ALTER TABLE subcription CHANGE User User INT NOT NULL, CHANGE Course Course INT NOT NULL');
        $this->addSql('ALTER TABLE supportfiles CHANGE Lesson Lesson INT NOT NULL');
    }
}
