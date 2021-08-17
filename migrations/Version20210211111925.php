<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210211111925 extends AbstractMigration
{
    public function getDescription() : string
    {
        return '';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE comment (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, description LONGTEXT NOT NULL, created_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_9474526CA76ED395 (user_id), INDEX IDX_9474526CED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE metier (id INT AUTO_INCREMENT NOT NULL, name VARCHAR(255) NOT NULL, created_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE picture (id INT AUTO_INCREMENT NOT NULL, service_id INT NOT NULL, name VARCHAR(255) NOT NULL, created_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_16DB4F89ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, name VARCHAR(255) NOT NULL, description LONGTEXT NOT NULL, price INT NOT NULL, primary_image VARCHAR(255) DEFAULT NULL, created_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_E19D9AD2A76ED395 (user_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE service_metier (service_id INT NOT NULL, metier_id INT NOT NULL, INDEX IDX_6F6708BAED5CA9E6 (service_id), INDEX IDX_6F6708BAED16FA20 (metier_id), PRIMARY KEY(service_id, metier_id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE user (id INT AUTO_INCREMENT NOT NULL, pseudo VARCHAR(180) DEFAULT NULL, email VARCHAR(180) DEFAULT NULL, first_name VARCHAR(255) DEFAULT NULL, last_name VARCHAR(255) DEFAULT NULL, birthdate DATETIME DEFAULT NULL, picture VARCHAR(255) DEFAULT NULL, langue VARCHAR(255) DEFAULT NULL, role VARCHAR(255) DEFAULT NULL, phone_number INT DEFAULT NULL, password VARCHAR(255) DEFAULT NULL, is_login TINYINT(1) NOT NULL, is_verified TINYINT(1) NOT NULL, is_active TINYINT(1) NOT NULL, description LONGTEXT DEFAULT NULL, qualification VARCHAR(255) DEFAULT NULL, city VARCHAR(255) DEFAULT NULL, street VARCHAR(255) DEFAULT NULL, adress_description LONGTEXT DEFAULT NULL, postal_code INT DEFAULT NULL, land_line_phone_number INT DEFAULT NULL, last_login_date DATETIME DEFAULT NULL, created_date DATETIME DEFAULT NULL, update_date DATETIME DEFAULT NULL, deleted_date DATETIME DEFAULT NULL, UNIQUE INDEX UNIQ_8D93D64986CC499D (pseudo), UNIQUE INDEX UNIQ_8D93D649E7927C74 (email), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE vote (id INT AUTO_INCREMENT NOT NULL, user_id INT NOT NULL, service_id INT NOT NULL, up_down INT DEFAULT NULL, is_active TINYINT(1) NOT NULL, INDEX IDX_5A108564A76ED395 (user_id), INDEX IDX_5A108564ED5CA9E6 (service_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CA76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE comment ADD CONSTRAINT FK_9474526CED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE picture ADD CONSTRAINT FK_16DB4F89ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
        $this->addSql('ALTER TABLE service ADD CONSTRAINT FK_E19D9AD2A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE service_metier ADD CONSTRAINT FK_6F6708BAED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE service_metier ADD CONSTRAINT FK_6F6708BAED16FA20 FOREIGN KEY (metier_id) REFERENCES metier (id) ON DELETE CASCADE');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564A76ED395 FOREIGN KEY (user_id) REFERENCES user (id)');
        $this->addSql('ALTER TABLE vote ADD CONSTRAINT FK_5A108564ED5CA9E6 FOREIGN KEY (service_id) REFERENCES service (id)');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE service_metier DROP FOREIGN KEY FK_6F6708BAED16FA20');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CED5CA9E6');
        $this->addSql('ALTER TABLE picture DROP FOREIGN KEY FK_16DB4F89ED5CA9E6');
        $this->addSql('ALTER TABLE service_metier DROP FOREIGN KEY FK_6F6708BAED5CA9E6');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564ED5CA9E6');
        $this->addSql('ALTER TABLE comment DROP FOREIGN KEY FK_9474526CA76ED395');
        $this->addSql('ALTER TABLE service DROP FOREIGN KEY FK_E19D9AD2A76ED395');
        $this->addSql('ALTER TABLE vote DROP FOREIGN KEY FK_5A108564A76ED395');
        $this->addSql('DROP TABLE comment');
        $this->addSql('DROP TABLE metier');
        $this->addSql('DROP TABLE picture');
        $this->addSql('DROP TABLE service');
        $this->addSql('DROP TABLE service_metier');
        $this->addSql('DROP TABLE user');
        $this->addSql('DROP TABLE vote');
    }
}
