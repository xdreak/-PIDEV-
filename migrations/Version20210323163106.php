<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210323163106 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE abonnment');
        $this->addSql('DROP TABLE career_advice');
        $this->addSql('DROP TABLE event');
        $this->addSql('DROP TABLE formation');
        $this->addSql('ALTER TABLE offre ADD CONSTRAINT FK_AF86866F1E5D0459 FOREIGN KEY (test_id) REFERENCES quiz (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_AF86866F1E5D0459 ON offre (test_id)');
        $this->addSql('ALTER TABLE quiz ADD CONSTRAINT FK_A412FA9247DCA1EC FOREIGN KEY (finder_id) REFERENCES offre (id)');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_A412FA9247DCA1EC ON quiz (finder_id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE abonnment (id INT AUTO_INCREMENT NOT NULL, nom_user VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, titre_formation VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, statue VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE career_advice (id INT AUTO_INCREMENT NOT NULL, article VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, cv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lettre_motiv VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lettre_rec VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, video VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE event (id INT AUTO_INCREMENT NOT NULL, nom VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, lieu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE formation (id INT AUTO_INCREMENT NOT NULL, titre VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, date DATE NOT NULL, lieu VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, description LONGTEXT CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, prix INT NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE offre DROP FOREIGN KEY FK_AF86866F1E5D0459');
        $this->addSql('DROP INDEX UNIQ_AF86866F1E5D0459 ON offre');
        $this->addSql('ALTER TABLE quiz DROP FOREIGN KEY FK_A412FA9247DCA1EC');
        $this->addSql('DROP INDEX UNIQ_A412FA9247DCA1EC ON quiz');
    }
}
