<?php

declare(strict_types=1);

namespace DoctrineMigrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\Migrations\AbstractMigration;

final class Version20250812111000 extends AbstractMigration
{
    public function getDescription(): string
    {
        return 'Create cat table';
    }

    public function up(Schema $schema): void
    {
        $table = $schema->createTable('cat');
        $table->addColumn('id', 'integer', ['autoincrement' => true]);
        $table->addColumn('name', 'string', ['length' => 255]);
        $table->addColumn('description', 'text');
        $table->setPrimaryKey(['id']);
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('cat');
    }
}
