<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20250321170833 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // Crée la table 'categorie' seulement si elle n'existe pas déjà
        $this->addSql('CREATE TABLE IF NOT EXISTS categorie (
            id INT AUTO_INCREMENT NOT NULL, 
            libelle VARCHAR(50) NOT NULL, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');

        // Supprime la table 'category' si elle existe déjà
        $this->addSql('DROP TABLE IF EXISTS category');

        // Modifie la colonne 'date_envoi' dans la table 'contact'
        $this->addSql('ALTER TABLE contact CHANGE date_envoi date_envoi DATETIME NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // Annule la création de la table 'categorie' et restaure 'category'
        $this->addSql('CREATE TABLE category (
            id INT AUTO_INCREMENT NOT NULL, 
            libelle VARCHAR(255) CHARACTER SET utf8mb4 NOT NULL COLLATE `utf8mb4_unicode_ci`, 
            PRIMARY KEY(id)
        ) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB COMMENT = \'\' ');

        // Supprime la table 'categorie' si elle existe
        $this->addSql('DROP TABLE IF EXISTS categorie');

        // Restaure la colonne 'date_envoi' dans la table 'contact' avec le type précédent
        $this->addSql('ALTER TABLE contact CHANGE date_envoi date_envoi VARCHAR(255) NOT NULL');
    }
}
