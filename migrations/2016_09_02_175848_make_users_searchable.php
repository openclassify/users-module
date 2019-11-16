<?php

use Anomaly\Streams\Platform\Database\Migration\Migration;

/**
 * Class MakeUsersSearchable
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class MakeUsersSearchable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $this->streams()
            ->findBySlugAndNamespace('users', 'users')
            ->setAttribute('searchable', true)
            ->save();
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $this->streams()
            ->findBySlugAndNamespace('users', 'users')
            ->setAttribute('searchable', false)
            ->save();
    }
}
