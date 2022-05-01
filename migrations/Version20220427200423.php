<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220427200423 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE board_game (id INT AUTO_INCREMENT NOT NULL, gamme_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT DEFAULT NULL, nb_min_player INT NOT NULL, nb_max_player INT NOT NULL, game_time INT NOT NULL, age_min INT NOT NULL, target VARCHAR(255) NOT NULL, price DOUBLE PRECISION NOT NULL, date_add DATETIME NOT NULL, date_update DATETIME NOT NULL, INDEX IDX_F9BD68AFD2FD85F1 (gamme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_game_market (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, market_id INT NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_D4E2D970AC91F10A (board_game_id), INDEX IDX_D4E2D970622F3F37 (market_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_game_theme (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, theme_id INT NOT NULL, INDEX IDX_9484A3BAC91F10A (board_game_id), INDEX IDX_9484A3B59027487 (theme_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE board_game_type (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, type_id INT NOT NULL, INDEX IDX_D5E6C72EAC91F10A (board_game_id), INDEX IDX_D5E6C72EC54C8C93 (type_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE expansion (id INT AUTO_INCREMENT NOT NULL, main_game_id INT NOT NULL, expansion_id INT NOT NULL, is_dependant TINYINT(1) NOT NULL, INDEX IDX_F0695B7210C470EC (main_game_id), UNIQUE INDEX UNIQ_F0695B725C15249D (expansion_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE image (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, link VARCHAR(255) NOT NULL, is_first TINYINT(1) NOT NULL, INDEX IDX_C53D045FAC91F10A (board_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE market (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, link VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE `range` (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE theme (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE type (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE video (id INT AUTO_INCREMENT NOT NULL, board_game_id INT NOT NULL, link VARCHAR(255) NOT NULL, INDEX IDX_7CC7DA2CAC91F10A (board_game_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE messenger_messages (id BIGINT AUTO_INCREMENT NOT NULL, body LONGTEXT NOT NULL, headers LONGTEXT NOT NULL, queue_name VARCHAR(190) NOT NULL, created_at DATETIME NOT NULL, available_at DATETIME NOT NULL, delivered_at DATETIME DEFAULT NULL, INDEX IDX_75EA56E0FB7336F0 (queue_name), INDEX IDX_75EA56E0E3BD61CE (available_at), INDEX IDX_75EA56E016BA31DB (delivered_at), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE board_game ADD CONSTRAINT FK_F9BD68AFD2FD85F1 FOREIGN KEY (gamme_id) REFERENCES `range` (id)');
        $this->addSql('ALTER TABLE board_game_market ADD CONSTRAINT FK_D4E2D970AC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE board_game_market ADD CONSTRAINT FK_D4E2D970622F3F37 FOREIGN KEY (market_id) REFERENCES market (id)');
        $this->addSql('ALTER TABLE board_game_theme ADD CONSTRAINT FK_9484A3BAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE board_game_theme ADD CONSTRAINT FK_9484A3B59027487 FOREIGN KEY (theme_id) REFERENCES theme (id)');
        $this->addSql('ALTER TABLE board_game_type ADD CONSTRAINT FK_D5E6C72EAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE board_game_type ADD CONSTRAINT FK_D5E6C72EC54C8C93 FOREIGN KEY (type_id) REFERENCES type (id)');
        $this->addSql('ALTER TABLE expansion ADD CONSTRAINT FK_F0695B7210C470EC FOREIGN KEY (main_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE expansion ADD CONSTRAINT FK_F0695B725C15249D FOREIGN KEY (expansion_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE image ADD CONSTRAINT FK_C53D045FAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
        $this->addSql('ALTER TABLE video ADD CONSTRAINT FK_7CC7DA2CAC91F10A FOREIGN KEY (board_game_id) REFERENCES board_game (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE board_game_market DROP FOREIGN KEY FK_D4E2D970AC91F10A');
        $this->addSql('ALTER TABLE board_game_theme DROP FOREIGN KEY FK_9484A3BAC91F10A');
        $this->addSql('ALTER TABLE board_game_type DROP FOREIGN KEY FK_D5E6C72EAC91F10A');
        $this->addSql('ALTER TABLE expansion DROP FOREIGN KEY FK_F0695B7210C470EC');
        $this->addSql('ALTER TABLE expansion DROP FOREIGN KEY FK_F0695B725C15249D');
        $this->addSql('ALTER TABLE image DROP FOREIGN KEY FK_C53D045FAC91F10A');
        $this->addSql('ALTER TABLE video DROP FOREIGN KEY FK_7CC7DA2CAC91F10A');
        $this->addSql('ALTER TABLE board_game_market DROP FOREIGN KEY FK_D4E2D970622F3F37');
        $this->addSql('ALTER TABLE board_game DROP FOREIGN KEY FK_F9BD68AFD2FD85F1');
        $this->addSql('ALTER TABLE board_game_theme DROP FOREIGN KEY FK_9484A3B59027487');
        $this->addSql('ALTER TABLE board_game_type DROP FOREIGN KEY FK_D5E6C72EC54C8C93');
        $this->addSql('DROP TABLE board_game');
        $this->addSql('DROP TABLE board_game_market');
        $this->addSql('DROP TABLE board_game_theme');
        $this->addSql('DROP TABLE board_game_type');
        $this->addSql('DROP TABLE expansion');
        $this->addSql('DROP TABLE image');
        $this->addSql('DROP TABLE market');
        $this->addSql('DROP TABLE `range`');
        $this->addSql('DROP TABLE theme');
        $this->addSql('DROP TABLE type');
        $this->addSql('DROP TABLE video');
        $this->addSql('DROP TABLE messenger_messages');
    }
}
