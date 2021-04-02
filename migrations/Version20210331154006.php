<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210331154006 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE candidature_stage (id INT AUTO_INCREMENT NOT NULL, id_stage_id INT DEFAULT NULL, nom VARCHAR(255) NOT NULL, prenom VARCHAR(255) NOT NULL, email VARCHAR(255) NOT NULL, age INT NOT NULL, commentaire VARCHAR(255) DEFAULT NULL, INDEX IDX_FC06FA3D72433D06 (id_stage_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE offre_stage (id INT AUTO_INCREMENT NOT NULL, finder_id INT DEFAULT NULL, nom_entreprise VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, stage_id VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_955674F247DCA1EC (finder_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE quiz2 (id INT AUTO_INCREMENT NOT NULL, id_stage_q_id INT DEFAULT NULL, titre VARCHAR(255) DEFAULT NULL, q1 VARCHAR(255) DEFAULT NULL, r1 VARCHAR(255) DEFAULT NULL, c1 VARCHAR(255) DEFAULT NULL, q2 VARCHAR(255) DEFAULT NULL, r2 VARCHAR(255) DEFAULT NULL, c2 VARCHAR(255) DEFAULT NULL, q3 VARCHAR(255) DEFAULT NULL, r3 VARCHAR(255) DEFAULT NULL, c3 VARCHAR(255) DEFAULT NULL, q4 VARCHAR(255) DEFAULT NULL, r4 VARCHAR(255) DEFAULT NULL, c4 VARCHAR(255) DEFAULT NULL, q5 VARCHAR(255) DEFAULT NULL, r5 VARCHAR(255) DEFAULT NULL, c5 VARCHAR(255) DEFAULT NULL, UNIQUE INDEX UNIQ_4705E9FC988B85 (id_stage_q_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE candidature_stage ADD CONSTRAINT FK_FC06FA3D72433D06 FOREIGN KEY (id_stage_id) REFERENCES offre_stage (id)');
        $this->addSql('ALTER TABLE offre_stage ADD CONSTRAINT FK_955674F247DCA1EC FOREIGN KEY (finder_id) REFERENCES quiz (id)');
        $this->addSql('ALTER TABLE quiz2 ADD CONSTRAINT FK_4705E9FC988B85 FOREIGN KEY (id_stage_q_id) REFERENCES offre_stage (id) ON DELETE CASCADE');
        $this->addSql('DROP TABLE career_advice');
        $this->addSql('ALTER TABLE event ADD datefin DATE NOT NULL, ADD adresse VARCHAR(255) NOT NULL, ADD creator_id INT NOT NULL, CHANGE date datedebut DATE NOT NULL, CHANGE description plan LONGTEXT NOT NULL, CHANGE lieu ville VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE candidature_stage DROP FOREIGN KEY FK_FC06FA3D72433D06');
        $this->addSql('ALTER TABLE quiz2 DROP FOREIGN KEY FK_4705E9FC988B85');
        $this->addSql('CREATE TABLE career_advice (id INT AUTO_INCREMENT NOT NULL, article VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lettre_motiv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lettre_rec VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, video VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('DROP TABLE candidature_stage');
        $this->addSql('DROP TABLE offre_stage');
        $this->addSql('DROP TABLE quiz2');
        $this->addSql('ALTER TABLE event ADD lieu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, ADD date DATE NOT NULL, DROP datedebut, DROP datefin, DROP ville, DROP adresse, DROP creator_id, CHANGE plan description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`');
    }
}
