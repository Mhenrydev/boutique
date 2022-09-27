<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20220927120856 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderslines DROP FOREIGN KEY FK_BCF13D26CFFE9AD6');
        $this->addSql('ALTER TABLE orderslines ADD CONSTRAINT FK_BCF13D26CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id) ON DELETE CASCADE');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE orderslines DROP FOREIGN KEY FK_BCF13D26CFFE9AD6');
        $this->addSql('ALTER TABLE orderslines ADD CONSTRAINT FK_BCF13D26CFFE9AD6 FOREIGN KEY (orders_id) REFERENCES orders (id)');
    }
}
