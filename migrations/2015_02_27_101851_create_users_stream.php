<?php

use Anomaly\UsersModule\User\UserModel;
use Illuminate\Database\Migrations\Migration;
use Anomaly\Streams\Platform\Field\FieldSchema;
use Anomaly\Streams\Platform\Stream\StreamSchema;

/**
 * Class CreateUsersStream
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class CreateUsersStream extends Migration
{

    /**
     * Run the migration.
     */
    public function up()
    {
        $schema = new StreamSchema(UserModel::class);

        $schema->create(function (FieldSchema $schema) {
            foreach ($schema->stream->fields as $field) {
                $schema->add($field);
            }
        });

        $schema = new StreamSchema(UserModel::class);
    }

    /**
     * Revert the migration.
     */
    public function down()
    {
        (new StreamSchema(UserModel::class))->drop(UserModel::class);
    }
}
