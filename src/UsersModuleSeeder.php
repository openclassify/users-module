<?php

namespace Anomaly\UsersModule;

use Illuminate\Database\Seeder;
use Anomaly\UsersModule\Role\RoleSeeder;
use Anomaly\UsersModule\User\UserSeeder;

/**
 * Class UsersModuleSeeder
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class UsersModuleSeeder extends Seeder
{

    /**
     * Run the seeder.
     */
    public function run()
    {
        $this->call(RoleSeeder::class);
        $this->call(UserSeeder::class);
    }
}
