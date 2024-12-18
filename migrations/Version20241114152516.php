<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20241114152516 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country ADD name VARCHAR(255) NOT NULL, ADD capital VARCHAR(255) NOT NULL, ADD region VARCHAR(255) NOT NULL, ADD subregion VARCHAR(255) NOT NULL, ADD population DOUBLE PRECISION NOT NULL, ADD area DOUBLE PRECISION NOT NULL, ADD continent VARCHAR(255) NOT NULL, ADD flag VARCHAR(255) NOT NULL');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE country DROP name, DROP capital, DROP region, DROP subregion, DROP population, DROP area, DROP continent, DROP flag');
    }
}
