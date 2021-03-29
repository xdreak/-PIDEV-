<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210329101716 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE participant_event_event DROP FOREIGN KEY FK_8086460E7FB66D76');
        $this->addSql('DROP TABLE participant_event');
        $this->addSql('DROP TABLE participant_event_event');
        $this->addSql('ALTER TABLE artiles CHANGE majle majle DATE NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE participant_event (id INT AUTO_INCREMENT NOT NULL, user_id INT DEFAULT NULL, INDEX IDX_FA1BA31EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('CREATE TABLE participant_event_event (participant_event_id INT NOT NULL, event_id INT NOT NULL, INDEX IDX_8086460E7FB66D76 (participant_event_id), INDEX IDX_8086460E71F7E88B (event_id), PRIMARY KEY(participant_event_id, event_id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');
        $this->addSql('ALTER TABLE participant_event ADD CONSTRAINT FK_FA1BA31EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE participant_event_event ADD CONSTRAINT FK_8086460E71F7E88B FOREIGN KEY (event_id) REFERENCES event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE participant_event_event ADD CONSTRAINT FK_8086460E7FB66D76 FOREIGN KEY (participant_event_id) REFERENCES participant_event (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE artiles CHANGE majle majle DATE DEFAULT NULL');
    }
}
