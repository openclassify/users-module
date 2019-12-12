<?php

namespace Anomaly\UsersModule\Role;

use Anomaly\Streams\Platform\Database\Seeder\Seeder;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;

/**
 * Class RoleSeeder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RoleSeeder extends Seeder
{

    /**
     * The role repository.
     *
     * @var RoleRepositoryInterface
     */
    protected $roles;

    /**
     * Create a new RoleSeeder instance.
     *
     * @param RoleRepositoryInterface $roles
     */
    public function __construct(RoleRepositoryInterface $roles)
    {
        parent::__construct();

        $this->roles = $roles;
    }

    /**
     * Run the seeder.
     */
    public function run()
    {
        $locale = config('app.fallback_locale', 'en');

        $this->roles->create(
            [
                'name' => [
                    $locale => 'Admin',
                ],
                'description' => [
                    $locale => 'The super admin role.',
                ],
                'slug' => 'admin',
            ]
        );

        $this->roles->create(
            [
                'name' => [
                    $locale => 'User',
                ],
                'description' => [
                    $locale => 'The default user role.',
                ],
                'slug' => 'user',
            ]
        );

        $this->roles->create(
            [
                'name' => [
                    $locale => 'Guest',
                ],
                'description' => [
                    $locale => 'The fallback role for non-users.',
                ],
                'slug' => 'guest',
            ]
        );
    }
}
