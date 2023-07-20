<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230623200519 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE emploi_temps (id INT AUTO_INCREMENT NOT NULL, matiere_id INT DEFAULT NULL, professeur_id INT DEFAULT NULL, classe_id INT DEFAULT NULL, salle_id INT DEFAULT NULL, jour VARCHAR(255) NOT NULL, heure_debut TIME NOT NULL, heure_fin TIME NOT NULL, INDEX IDX_50D1B05EF46CD258 (matiere_id), INDEX IDX_50D1B05EBAB22EE9 (professeur_id), INDEX IDX_50D1B05E8F5EA509 (classe_id), INDEX IDX_50D1B05EDC304035 (salle_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE emploi_temps ADD CONSTRAINT FK_50D1B05EF46CD258 FOREIGN KEY (matiere_id) REFERENCES matiere (id)');
        $this->addSql('ALTER TABLE emploi_temps ADD CONSTRAINT FK_50D1B05EBAB22EE9 FOREIGN KEY (professeur_id) REFERENCES proffesseur (id)');
        $this->addSql('ALTER TABLE emploi_temps ADD CONSTRAINT FK_50D1B05E8F5EA509 FOREIGN KEY (classe_id) REFERENCES classe (id)');
        $this->addSql('ALTER TABLE emploi_temps ADD CONSTRAINT FK_50D1B05EDC304035 FOREIGN KEY (salle_id) REFERENCES salle (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE emploi_temps DROP FOREIGN KEY FK_50D1B05EF46CD258');
        $this->addSql('ALTER TABLE emploi_temps DROP FOREIGN KEY FK_50D1B05EBAB22EE9');
        $this->addSql('ALTER TABLE emploi_temps DROP FOREIGN KEY FK_50D1B05E8F5EA509');
        $this->addSql('ALTER TABLE emploi_temps DROP FOREIGN KEY FK_50D1B05EDC304035');
        $this->addSql('DROP TABLE emploi_temps');
    }
}
