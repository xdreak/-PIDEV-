<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210311143726 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
     //   $this->addSql('ALTER TABLE articlelike ADD CONSTRAINT FK_73177A33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
       // $this->addSql('ALTER TABLE artiles ADD nombrelike INT NOT NULL');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
      //  $this->addSql('ALTER TABLE articlelike ADD CONSTRAINT FK_73177A33A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
       // $this->addSql('ALTER TABLE artiles ADD nombrelike INT NOT NULL');

    }
}
