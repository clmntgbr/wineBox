<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200803103014 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE wine_box DROP FOREIGN KEY FK_65390151CDE46FDB');
        $this->addSql('ALTER TABLE wine_box DROP FOREIGN KEY FK_65390151DE12AB56');
        $this->addSql('DROP INDEX uniq_65390151989d9b62 ON wine_box');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA33561D989D9B62 ON wine_box (slug)');
        $this->addSql('DROP INDEX idx_65390151de12ab56 ON wine_box');
        $this->addSql('CREATE INDEX IDX_DA33561DDE12AB56 ON wine_box (created_by)');
        $this->addSql('DROP INDEX uniq_65390151cde46fdb ON wine_box');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_DA33561DCDE46FDB ON wine_box (preview_id)');
        $this->addSql('ALTER TABLE wine_box ADD CONSTRAINT FK_65390151CDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
        $this->addSql('ALTER TABLE wine_box ADD CONSTRAINT FK_65390151DE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_bottle DROP FOREIGN KEY FK_5530BC67D4A8C468');
        $this->addSql('DROP INDEX idx_5530bc67d4a8c468 ON wine_bottle');
        $this->addSql('CREATE INDEX IDX_5530BC67D8177B3F ON wine_bottle (box_id)');
        $this->addSql('ALTER TABLE wine_bottle ADD CONSTRAINT FK_5530BC67D4A8C468 FOREIGN KEY (box_id) REFERENCES wine_box (id)');
        $this->addSql('ALTER TABLE country ADD popularity DOUBLE PRECISION DEFAULT \'0\' NOT NULL');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D4A8C468');
        $this->addSql('DROP INDEX uniq_8d93d649d4a8c468 ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D8177B3F ON user (box_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D4A8C468 FOREIGN KEY (box_id) REFERENCES wine_box (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->abortIf($this->connection->getDatabasePlatform()->getName() !== 'mysql', 'Migration can only be executed safely on \'mysql\'.');

        $this->addSql('ALTER TABLE country DROP popularity');
        $this->addSql('ALTER TABLE user DROP FOREIGN KEY FK_8D93D649D8177B3F');
        $this->addSql('DROP INDEX uniq_8d93d649d8177b3f ON user');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_8D93D649D4A8C468 ON user (box_id)');
        $this->addSql('ALTER TABLE user ADD CONSTRAINT FK_8D93D649D8177B3F FOREIGN KEY (box_id) REFERENCES wine_box (id)');
        $this->addSql('ALTER TABLE wine_bottle DROP FOREIGN KEY FK_5530BC67D8177B3F');
        $this->addSql('DROP INDEX idx_5530bc67d8177b3f ON wine_bottle');
        $this->addSql('CREATE INDEX IDX_5530BC67D4A8C468 ON wine_bottle (box_id)');
        $this->addSql('ALTER TABLE wine_bottle ADD CONSTRAINT FK_5530BC67D8177B3F FOREIGN KEY (box_id) REFERENCES wine_box (id)');
        $this->addSql('ALTER TABLE wine_box DROP FOREIGN KEY FK_DA33561DDE12AB56');
        $this->addSql('ALTER TABLE wine_box DROP FOREIGN KEY FK_DA33561DCDE46FDB');
        $this->addSql('DROP INDEX uniq_da33561dcde46fdb ON wine_box');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65390151CDE46FDB ON wine_box (preview_id)');
        $this->addSql('DROP INDEX uniq_da33561d989d9b62 ON wine_box');
        $this->addSql('CREATE UNIQUE INDEX UNIQ_65390151989D9B62 ON wine_box (slug)');
        $this->addSql('DROP INDEX idx_da33561dde12ab56 ON wine_box');
        $this->addSql('CREATE INDEX IDX_65390151DE12AB56 ON wine_box (created_by)');
        $this->addSql('ALTER TABLE wine_box ADD CONSTRAINT FK_DA33561DDE12AB56 FOREIGN KEY (created_by) REFERENCES user (id)');
        $this->addSql('ALTER TABLE wine_box ADD CONSTRAINT FK_DA33561DCDE46FDB FOREIGN KEY (preview_id) REFERENCES media (id)');
    }
}
