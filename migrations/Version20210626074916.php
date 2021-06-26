<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20210626074916 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE TABLE korzina (id INT AUTO_INCREMENT NOT NULL, items_id INT NOT NULL, session_id VARCHAR(255) NOT NULL, count INT NOT NULL, INDEX IDX_EC226EF16BB0AE84 (items_id), PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_items (id INT AUTO_INCREMENT NOT NULL, price INT NOT NULL, name VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('CREATE TABLE shop_order (id INT AUTO_INCREMENT NOT NULL, session_id INT NOT NULL, status INT NOT NULL, user_name VARCHAR(255) NOT NULL, user_email VARCHAR(255) NOT NULL, user_phone VARCHAR(255) NOT NULL, PRIMARY KEY(id)) DEFAULT CHARACTER SET utf8mb4 COLLATE `utf8mb4_unicode_ci` ENGINE = InnoDB');
        $this->addSql('ALTER TABLE korzina ADD CONSTRAINT FK_EC226EF16BB0AE84 FOREIGN KEY (items_id) REFERENCES shop_items (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE korzina DROP FOREIGN KEY FK_EC226EF16BB0AE84');
        $this->addSql('DROP TABLE korzina');
        $this->addSql('DROP TABLE shop_items');
        $this->addSql('DROP TABLE shop_order');
    }
}
