<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210325102521 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
//        $this->addSql('ALTER TABLE articlelike DROP FOREIGN KEY FK_73177A33A76ED395');
//        $this->addSql('DROP TABLE articlelike');
//        $this->addSql('DROP TABLE user');
//        $this->addSql('ALTER TABLE artiles CHANGE majle majle DATE ');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
//        $this->addSql('CREATE TABLE articlelike (id INT AUTO_INCREMENT NOT NULL, article_id INT DEFAULT NULL, user_id INT DEFAULT NULL, INDEX IDX_73177A33A76ED395 (user_id), INDEX IDX_73177A337294869C (article_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
//        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, email VARCHAR(180) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, roles JSON NOT NULL, password VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
//        $this->addSql('ALTER TABLE articlelike ADD CONSTRAINT FK_73177A337294869C FOREIGN KEY (article_id) REFERENCES artiles (id)');
//        $this->addSql('ALTER TABLE articlelike ADD CONSTRAINT FK_73177A33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
//        $this->addSql('ALTER TABLE artiles CHANGE majle majle DATE DEFAULT NULL');
    }
}
