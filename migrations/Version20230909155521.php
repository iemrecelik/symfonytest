<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20230909155521 extends AbstractMigration
{
    public function getDescription(): string
    {
        return '';
    }

    public function up(Schema $schema): void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_category DROP FOREIGN KEY FK_1FB30F9840B1D29E');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9840B1D29E FOREIGN KEY (book_category_id) REFERENCES book_category (id)');
    }

    public function down(Schema $schema): void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE book_category DROP FOREIGN KEY FK_1FB30F9840B1D29E');
        $this->addSql('ALTER TABLE book_category ADD CONSTRAINT FK_1FB30F9840B1D29E FOREIGN KEY (book_category_id) REFERENCES book_category (id) ON UPDATE NO ACTION ON DELETE SET NULL');
    }
}
