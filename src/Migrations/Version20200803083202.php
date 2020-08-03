<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200803083202 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('CREATE TABLE wine_cellar (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, horizontal INT NOT NULL, vertical INT NOT NULL, quantity DOUBLE PRECISION NOT NULL, liter DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_65390151989D9B62 (slug), INDEX IDX_65390151DE12AB56 (created_by), UNIQUE INDEX UNIQ_65390151CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_color (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, css_code VARCHAR(255) NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_469C1575989D9B62 (slug), INDEX IDX_469C1575DE12AB56 (created_by), UNIQUE INDEX UNIQ_469C1575CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_domain (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_5E300B39989D9B62 (slug), INDEX IDX_5E300B39DE12AB56 (created_by), UNIQUE INDEX UNIQ_5E300B39CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_region (id INT AUTO_INCREMENT NOT NULL, country_id INT DEFAULT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_F6FBE444989D9B62 (slug), INDEX IDX_F6FBE444F92F3E70 (country_id), INDEX IDX_F6FBE444DE12AB56 (created_by), UNIQUE INDEX UNIQ_F6FBE444CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine (id INT AUTO_INCREMENT NOT NULL, capacity_id INT DEFAULT NULL, color_id INT DEFAULT NULL, appellation_id INT DEFAULT NULL, region_id INT DEFAULT NULL, domain_id INT DEFAULT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, description LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_560C6468989D9B62 (slug), INDEX IDX_560C646866B6F0BA (capacity_id), INDEX IDX_560C64687ADA1FB5 (color_id), INDEX IDX_560C64687CDE30DD (appellation_id), INDEX IDX_560C646898260155 (region_id), INDEX IDX_560C6468115F0EE5 (domain_id), INDEX IDX_560C6468DE12AB56 (created_by), UNIQUE INDEX UNIQ_560C6468CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_capacity (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, value DOUBLE PRECISION NOT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_3545F877989D9B62 (slug), INDEX IDX_3545F877DE12AB56 (created_by), UNIQUE INDEX UNIQ_3545F877CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_bottle (id INT AUTO_INCREMENT NOT NULL, cellar_id INT DEFAULT NULL, wine_id INT DEFAULT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, location VARCHAR(255) DEFAULT NULL, family_code VARCHAR(255) NOT NULL, comment LONGTEXT DEFAULT NULL, purchase_price DOUBLE PRECISION DEFAULT NULL, status VARCHAR(255) NOT NULL, purchase_at DATETIME DEFAULT NULL, empty_at DATETIME DEFAULT NULL, apogee_at DATETIME DEFAULT NULL, alert_at DATETIME DEFAULT NULL, alert_comment LONGTEXT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_5530BC67989D9B62 (slug), INDEX IDX_5530BC67D4A8C468 (cellar_id), INDEX IDX_5530BC6728A2BD76 (wine_id), INDEX IDX_5530BC67DE12AB56 (created_by), UNIQUE INDEX UNIQ_5530BC67CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE wine_appellation (id INT AUTO_INCREMENT NOT NULL, created_by INT DEFAULT NULL, preview_id INT DEFAULT NULL, created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(128) NOT NULL, description LONGTEXT NOT NULL, popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL, UNIQUE INDEX UNIQ_93E0CE58989D9B62 (slug), INDEX IDX_93E0CE58DE12AB56 (created_by), UNIQUE INDEX UNIQ_93E0CE58CDE46FDB (preview_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE country (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, slug VARCHAR(255) NOT NULL, flag VARCHAR(255) NOT NULL, iso2 VARCHAR(255) NOT NULL, iso3 VARCHAR(255) NOT NULL, iso_numeric VARCHAR(255) NOT NULL, UNIQUE INDEX UNIQ_5373C966989D9B62 (slug), UNIQUE INDEX UNIQ_5373C9661B6F9774 (iso2), UNIQUE INDEX UNIQ_5373C9666C68A7E2 (iso3), UNIQUE INDEX UNIQ_5373C9668871CBE0 (iso_numeric), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, cellar_id INT DEFAULT NULL, created_by INT DEFAULT NULL, username VARCHAR(180) NOT NULL, username_canonical VARCHAR(180) NOT NULL, email VARCHAR(180) NOT NULL, email_canonical VARCHAR(180) NOT NULL, enabled TINYINT(1) NOT NULL, salt VARCHAR(255) DEFAULT NULL, password VARCHAR(255) NOT NULL, last_login DATETIME DEFAULT NULL, confirmation_token VARCHAR(180) DEFAULT NULL, password_requested_at DATETIME DEFAULT NULL, roles LONGTEXT NOT NULL COMMENT \'(DC2Type:array)\', created_at DATETIME NOT NULL, updated_at DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64992FC23A8 (username_canonical), UNIQUE INDEX UNIQ_8D93D649A0D96FBF (email_canonical), UNIQUE INDEX UNIQ_8D93D649C05FB297 (confirmation_token), UNIQUE INDEX UNIQ_8D93D649D4A8C468 (cellar_id), INDEX IDX_8D93D649DE12AB56 (created_by), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE media (id INT AUTO_INCREMENT NOT NULL, path VARCHAR(255) NOT NULL, name VARCHAR(255) NOT NULL, mime_type VARCHAR(255) NOT NULL, type VARCHAR(255) NOT NULL, size NUMERIC(10, 0) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8 COLLATE `utf8_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE wine_cellar ADD CONSTRAINT FK_65390151DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_cellar ADD CONSTRAINT FK_65390151CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_color ADD CONSTRAINT FK_469C1575DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_color ADD CONSTRAINT FK_469C1575CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_domain ADD CONSTRAINT FK_5E300B39DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_domain ADD CONSTRAINT FK_5E300B39CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_region ADD CONSTRAINT FK_F6FBE444F92F3E70 FOREIGN KEY (country_id) REFERENCES country (id)');
        $this->addSql('ALTER TABLE wine_region ADD CONSTRAINT FK_F6FBE444DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_region ADD CONSTRAINT FK_F6FBE444CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646866B6F0BA FOREIGN KEY (capacity_id) REFERENCES wine_capacity (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C64687ADA1FB5 FOREIGN KEY (color_id) REFERENCES wine_color (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C64687CDE30DD FOREIGN KEY (appellation_id) REFERENCES wine_appellation (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C646898260155 FOREIGN KEY (region_id) REFERENCES wine_region (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C6468115F0EE5 FOREIGN KEY (domain_id) REFERENCES wine_domain (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C6468DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine ADD CONSTRAINT FK_560C6468CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_capacity ADD CONSTRAINT FK_3545F877DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_capacity ADD CONSTRAINT FK_3545F877CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_bottle ADD CONSTRAINT FK_5530BC67D4A8C468 FOREIGN KEY (cellar_id) REFERENCES wine_cellar (id)');
        $this->addSql('ALTER TABLE wine_bottle ADD CONSTRAINT FK_5530BC6728A2BD76 FOREIGN KEY (wine_id) REFERENCES wine (id)');
        $this->addSql('ALTER TABLE wine_bottle ADD CONSTRAINT FK_5530BC67DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_bottle ADD CONSTRAINT FK_5530BC67CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_appellation ADD CONSTRAINT FK_93E0CE58DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_appellation ADD CONSTRAINT FK_93E0CE58CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D4A8C468 FOREIGN KEY (cellar_id) REFERENCES wine_cellar (id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wine_bottle DROP FOREIGN KEY FK_5530BC67D4A8C468');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D4A8C468');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C64687ADA1FB5');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C6468115F0EE5');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646898260155');
        $this->addSql('ALTER TABLE wine_bottle DROP FOREIGN KEY FK_5530BC6728A2BD76');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C646866B6F0BA');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C64687CDE30DD');
        $this->addSql('ALTER TABLE wine_region DROP FOREIGN KEY FK_F6FBE444F92F3E70');
        $this->addSql('ALTER TABLE wine_cellar DROP FOREIGN KEY FK_65390151DE12AB56');
        $this->addSql('ALTER TABLE wine_color DROP FOREIGN KEY FK_469C1575DE12AB56');
        $this->addSql('ALTER TABLE wine_domain DROP FOREIGN KEY FK_5E300B39DE12AB56');
        $this->addSql('ALTER TABLE wine_region DROP FOREIGN KEY FK_F6FBE444DE12AB56');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C6468DE12AB56');
        $this->addSql('ALTER TABLE wine_capacity DROP FOREIGN KEY FK_3545F877DE12AB56');
        $this->addSql('ALTER TABLE wine_bottle DROP FOREIGN KEY FK_5530BC67DE12AB56');
        $this->addSql('ALTER TABLE wine_appellation DROP FOREIGN KEY FK_93E0CE58DE12AB56');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649DE12AB56');
        $this->addSql('ALTER TABLE wine_cellar DROP FOREIGN KEY FK_65390151CDE46FDB');
        $this->addSql('ALTER TABLE wine_color DROP FOREIGN KEY FK_469C1575CDE46FDB');
        $this->addSql('ALTER TABLE wine_domain DROP FOREIGN KEY FK_5E300B39CDE46FDB');
        $this->addSql('ALTER TABLE wine_region DROP FOREIGN KEY FK_F6FBE444CDE46FDB');
        $this->addSql('ALTER TABLE wine DROP FOREIGN KEY FK_560C6468CDE46FDB');
        $this->addSql('ALTER TABLE wine_capacity DROP FOREIGN KEY FK_3545F877CDE46FDB');
        $this->addSql('ALTER TABLE wine_bottle DROP FOREIGN KEY FK_5530BC67CDE46FDB');
        $this->addSql('ALTER TABLE wine_appellation DROP FOREIGN KEY FK_93E0CE58CDE46FDB');
        $this->addSql('DROP TABLE wine_cellar');
        $this->addSql('DROP TABLE wine_color');
        $this->addSql('DROP TABLE wine_domain');
        $this->addSql('DROP TABLE wine_region');
        $this->addSql('DROP TABLE wine');
        $this->addSql('DROP TABLE wine_capacity');
        $this->addSql('DROP TABLE wine_bottle');
        $this->addSql('DROP TABLE wine_appellation');
        $this->addSql('DROP TABLE country');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE media');
    }
}
