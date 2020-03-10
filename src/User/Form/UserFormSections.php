<?php

namespace Anomaly\UsersModule\User\Form;

use Anomaly\UsersModule\User\UserModel;

/**
 * Class UserFormSections
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class UserFormSections
{

    /**
     * Handle the form sections.
     *
     * @param UserFormBuilder $builder
     */
    public function handle(UserFormBuilder $builder, UserModel $users)
    {
        $fields = [
            'first_name',
            'last_name',
            'display_name',
            'username',
            'email',
            'activated',
            'enabled',
            'password',
            'roles',
        ];

        $profileFields = $users->stream()->fields->slugs()->values()->all();

        $builder->setSections(
            [
                'user' => [
                    'tabs' => [
                        'account' => [
                            'title'  => 'anomaly.module.users::tab.account',
                            'fields' => $fields,
                        ],
                        'profile' => [
                            'title'  => 'anomaly.module.users::tab.profile',
                            'fields' => $profileFields,
                        ],
                    ],
                ],
            ]
        );
    }
}
