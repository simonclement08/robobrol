<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220508205209 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board_game_note (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, user_id INT NOT NULL, note INT NOT NULL, comment VARCHAR(255) DEFAULT NULL, INDEX IDX_96856A13AC91F10A (board_game_id), INDEX IDX_96856A13A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_game_owned (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_A589FE1EAC91F10A (board_game_id), INDEX IDX_A589FE1EA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_game_wish (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, user_id INT NOT NULL, INDEX IDX_8EE9E4CEAC91F10A (board_game_id), INDEX IDX_8EE9E4CEA76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE board_game_note ADD CONSTRAINT FK_96856A13AC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE board_game_note ADD CONSTRAINT FK_96856A13A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE board_game_owned ADD CONSTRAINT FK_A589FE1EAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE board_game_owned ADD CONSTRAINT FK_A589FE1EA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE board_game_wish ADD CONSTRAINT FK_8EE9E4CEAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE board_game_wish ADD CONSTRAINT FK_8EE9E4CEA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE user DROP is_verified');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('DROP TABLE board_game_note');
        $this->addSql('DROP TABLE board_game_owned');
        $this->addSql('DROP TABLE board_game_wish');
        $this->addSql('ALTER TABLE user ADD is_verified TINYINT(1) NOT NULL');
    }
}
