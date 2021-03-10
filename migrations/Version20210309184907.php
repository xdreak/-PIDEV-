<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210309184907 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE quiz (id INT AUTO_INCREMENT NOT NULL, id_stage_q_id INT NOT NULL, titre VARCHAR(255) DEFAULT NULL, q1 VARCHAR(255) DEFAULT NULL, r1 VARCHAR(255) DEFAULT NULL, c1 VARCHAR(255) DEFAULT NULL, q2 VARCHAR(255) DEFAULT NULL, r2 VARCHAR(255) DEFAULT NULL, c2 VARCHAR(255) DEFAULT NULL, q3 VARCHAR(255) DEFAULT NULL, r3 VARCHAR(255) DEFAULT NULL, c3 VARCHAR(255) DEFAULT NULL, q4 VARCHAR(255) DEFAULT NULL, r4 VARCHAR(255) DEFAULT NULL, c4 VARCHAR(255) DEFAULT NULL, q5 VARCHAR(255) DEFAULT NULL, r5 VARCHAR(255) DEFAULT NULL, c5 VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_A412FA92C988B85 (id_stage_q_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA92C988B85 FOREIGN KEY (id_stage_q_id) REFERENCES offre_stage (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE quiz');
    }
}
