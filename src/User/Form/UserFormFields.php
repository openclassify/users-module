<?php

namespace Anomaly\UsersModule\User\Form;

use Anomaly\UsersModule\User\UserModel;
use Anomaly\UsersModule\User\Validation\ValidatePassword;
use Anomaly\UsersModule\User\Validation\ValidateRoles;

/**
 * Class UserFormFields
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class UserFormFields
{

    /**
     * Handle the form fields.
     *
     * @param UserFormBuilder $builder
     */
    public function handle(UserFormBuilder $builder, UserModel $users)
    {
        $fields = [
            'first_name',
            'last_name',
            'display_name',
            'username' => [
                'html_attributes' => [
                    'autocomplete' => 'off',
                    'data-lpignore' => true,
                ]
            ],
            'email' => [
                'html_attributes' => [
                    'autocomplete' => 'off',
                    'data-lpignore' => true,
                ]
            ],
            'password' => [
                'value'      => '',
                'required'   => false,
                'rules'      => [
                    'required_if:password,*',
                    'valid_password',
                ],
                'validators' => [
                    'valid_password' => [
                        'message' => false,
                        'handler' => ValidatePassword::class,
                    ],
                ],
                'html_attributes' => [
                    'autocomplete' => 'off',
                    'data-lpignore' => true,
                ],
            ],
            'activated',
            'enabled',
            'roles'    => [
                'rules'      => [
                    'valid_roles',
                ],
                'validators' => [
                    'valid_roles' => [
                        'handler' => ValidateRoles::class,
                        'message' => 'anomaly.module.users::error.modify_admins',
                    ],
                ],
            ],
        ];

        $builder->setFields($fields);
    }
}
