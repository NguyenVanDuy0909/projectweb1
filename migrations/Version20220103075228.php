<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220103075228 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE brand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE cpu (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, image VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE demand_laptop (demand_id INT NOT NULL, laptop_id INT NOT NULL, INDEX IDX_90F4C3925D022E59 (demand_id), INDEX IDX_90F4C392D59905E5 (laptop_id), PRIMARY KEY(demand_id, laptop_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE laptop (id INT AUTO_INCREMENT NOT NULL, brand_id INT DEFAULT NULL, c_pu_id INT DEFAULT NULL, r_am_id INT DEFAULT NULL, size_id INT DEFAULT NULL, name VARCHAR(255) NOT NULL, madein VARCHAR(255) NOT NULL, price INT NOT NULL, price_discount INT NOT NULL, image VARCHAR(255) NOT NULL, INDEX IDX_E001563B44F5D008 (brand_id), INDEX IDX_E001563BE6D99F67 (c_pu_id), INDEX IDX_E001563BEF5DC95F (r_am_id), INDEX IDX_E001563B498DA827 (size_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE ram (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE size (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, description VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE demand_laptop ADD CONSTRAINT FK_90F4C3925D022E59 FOREIGN KEY (demand_id) REFERENCES demand (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE demand_laptop ADD CONSTRAINT FK_90F4C392D59905E5 FOREIGN KEY (laptop_id) REFERENCES laptop (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE laptop ADD CONSTRAINT FK_E001563B44F5D008 FOREIGN KEY (brand_id) REFERENCES brand (id)');
        $this->addSql('ALTER TABLE laptop ADD CONSTRAINT FK_E001563BE6D99F67 FOREIGN KEY (c_pu_id) REFERENCES cpu (id)');
        $this->addSql('ALTER TABLE laptop ADD CONSTRAINT FK_E001563BEF5DC95F FOREIGN KEY (r_am_id) REFERENCES ram (id)');
        $this->addSql('ALTER TABLE laptop ADD CONSTRAINT FK_E001563B498DA827 FOREIGN KEY (size_id) REFERENCES size (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE laptop DROP FOREIGN KEY FK_E001563B44F5D008');
        $this->addSql('ALTER TABLE laptop DROP FOREIGN KEY FK_E001563BE6D99F67');
        $this->addSql('ALTER TABLE demand_laptop DROP FOREIGN KEY FK_90F4C3925D022E59');
        $this->addSql('ALTER TABLE demand_laptop DROP FOREIGN KEY FK_90F4C392D59905E5');
        $this->addSql('ALTER TABLE laptop DROP FOREIGN KEY FK_E001563BEF5DC95F');
        $this->addSql('ALTER TABLE laptop DROP FOREIGN KEY FK_E001563B498DA827');
        $this->addSql('DROP TABLE brand');
        $this->addSql('DROP TABLE cpu');
        $this->addSql('DROP TABLE demand');
        $this->addSql('DROP TABLE demand_laptop');
        $this->addSql('DROP TABLE laptop');
        $this->addSql('DROP TABLE ram');
        $this->addSql('DROP TABLE size');
    }
}
