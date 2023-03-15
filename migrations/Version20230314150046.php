<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230314150046 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE song_playlist (song_id INT NOT NULL, playlist_id INT NOT NULL, INDEX IDX_7C5E4765A0BDB2F3 (song_id), INDEX IDX_7C5E47656BBD148 (playlist_id), PRIMARY KEY(song_id, playlist_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE song_playlist ADD CONSTRAINT FK_7C5E4765A0BDB2F3 FOREIGN KEY (song_id) REFERENCES song (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE song_playlist ADD CONSTRAINT FK_7C5E47656BBD148 FOREIGN KEY (playlist_id) REFERENCES playlist (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE song DROP FOREIGN KEY FK_33EDEEA19F70CF56');
        $this->addSql('DROP INDEX IDX_33EDEEA19F70CF56 ON song');
        $this->addSql('ALTER TABLE song DROP playlists_id, CHANGE album_id album_id INT DEFAULT NULL, CHANGE duration duration INT DEFAULT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE song_playlist DROP FOREIGN KEY FK_7C5E4765A0BDB2F3');
        $this->addSql('ALTER TABLE song_playlist DROP FOREIGN KEY FK_7C5E47656BBD148');
        $this->addSql('DROP TABLE song_playlist');
        $this->addSql('ALTER TABLE song ADD playlists_id INT NOT NULL, CHANGE album_id album_id INT NOT NULL, CHANGE duration duration INT NOT NULL');
        $this->addSql('ALTER TABLE song ADD CONSTRAINT FK_33EDEEA19F70CF56 FOREIGN KEY (playlists_id) REFERENCES playlist_song (id)');
        $this->addSql('CREATE INDEX IDX_33EDEEA19F70CF56 ON song (playlists_id)');
    }
}
