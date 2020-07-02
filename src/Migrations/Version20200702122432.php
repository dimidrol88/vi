<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

/**
 * Auto-generated Migration: Please modify to your needs!
 */
final class Version20200702122432 extends AbstractMigration
{
    public function getDescription() : string
    {
        return 'Добавление таблиц: заказ и выбранных товаров';
    }

    public function up(Schema $schema) : void
    {
        // this up() migration is auto-generated, please modify it to your needs
        $this->addSql('CREATE SEQUENCE "order_items_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE SEQUENCE "orders_id_seq" INCREMENT BY 1 MINVALUE 1 START 1');
        $this->addSql('CREATE TABLE "order_items" (id INT NOT NULL, product_id INT NOT NULL, order_id INT NOT NULL, PRIMARY KEY(id))');
        $this->addSql('CREATE INDEX IDX_62809DB04584665A ON "order_items" (product_id)');
        $this->addSql('CREATE INDEX IDX_62809DB08D9F6D38 ON "order_items" (order_id)');
        $this->addSql('CREATE TABLE "orders" (id INT NOT NULL, user_id INT NOT NULL, status VARCHAR(10) NOT NULL, price NUMERIC(10, 2) NOT NULL, created TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, updated TIMESTAMP(0) WITHOUT TIME ZONE NOT NULL, PRIMARY KEY(id))');
        $this->addSql('COMMENT ON COLUMN "orders".created IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('COMMENT ON COLUMN "orders".updated IS \'(DC2Type:datetime_immutable)\'');
        $this->addSql('ALTER TABLE "order_items" ADD CONSTRAINT FK_62809DB04584665A FOREIGN KEY (product_id) REFERENCES products (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
        $this->addSql('ALTER TABLE "order_items" ADD CONSTRAINT FK_62809DB08D9F6D38 FOREIGN KEY (order_id) REFERENCES "orders" (id) ON DELETE CASCADE NOT DEFERRABLE INITIALLY IMMEDIATE');
    }

    public function down(Schema $schema) : void
    {
        // this down() migration is auto-generated, please modify it to your needs
        $this->addSql('ALTER TABLE "order_items" DROP CONSTRAINT FK_62809DB08D9F6D38');
        $this->addSql('DROP SEQUENCE "order_items_id_seq" CASCADE');
        $this->addSql('DROP SEQUENCE "orders_id_seq" CASCADE');
        $this->addSql('DROP TABLE "order_items"');
        $this->addSql('DROP TABLE "orders"');
    }
}
