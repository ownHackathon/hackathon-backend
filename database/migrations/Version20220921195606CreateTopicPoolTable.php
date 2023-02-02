<?php declare(strict_types=1);

namespace Migrations;

use Doctrine\DBAL\Schema\Schema;
use Doctrine\DBAL\Types\Types;
use Doctrine\Migrations\AbstractMigration;

final class Version20220921195606CreateTopicPoolTable extends AbstractMigration
{
    public function up(Schema $schema): void
    {
        $table = $schema->createTable('TopicPool');

        $table->addColumn('id', Types::INTEGER, ['autoincrement' => true, 'unsigned' => true,]);
        $table->addColumn('uuid', Types::STRING, ['length' => 32]);
        $table->addColumn('eventId', Types::INTEGER, ['unsigned' => true, 'notnull' => false]);
        $table->addColumn('topic', Types::STRING);
        $table->addColumn('description', Types::TEXT, ['notnull' => false]);
        $table->addColumn('accepted', Types::BOOLEAN, ['notnull' => false]);

        $table->setPrimaryKey(['id']);
        $table->addUniqueIndex(['uuid'], 'uuid_UNIQUE');
        $table->addUniqueIndex(['topic'], 'topic_UNIQUE');
    }

    public function down(Schema $schema): void
    {
        $schema->dropTable('TopicPool');
    }
}
