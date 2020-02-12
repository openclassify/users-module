<?php

use Anomaly\UsersModule\Role\RoleModel;
use Illuminate\Database\Migrations\Migration;
use Anomaly\Streams\Platform\Field\FieldSchema;
use Anomaly\Streams\Platform\Stream\StreamSchema;

/**
 * Class CreateRolesStream
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateRolesStream extends Migration
{

    /**
     * Run the migration.
     */
    public function up()
    {
        $schema = new StreamSchema(RoleModel::class);

        $schema->create(function (FieldSchema $schema) {
            foreach ($schema->stream->fields as $field) {
                $schema->add($field);
            }
        });

        $schema = new StreamSchema(RoleModel::class);
    }

    /**
     * Revert the migration.
     */
    public function down()
    {
        (new StreamSchema(RoleModel::class))->drop(RoleModel::class);
    }
}
