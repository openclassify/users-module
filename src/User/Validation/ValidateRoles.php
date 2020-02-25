<?php

namespace Anomaly\UsersModule\User\Validation;

use Anomaly\Streams\Platform\Message\MessageManger;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;

/**
 * Class ValidateRoles
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class ValidateRoles
{

    /**
     * Handle the validation.
     *
     * @param RoleRepositoryInterface  $roles
     * @param MessageManger               $messages
     * @param Authorizer               $authorizer
     * @param                          $value
     * @return bool
     */
    public function handle(RoleRepositoryInterface $roles, MessageManger $messages, Authorizer $authorizer, $value)
    {
        $admin = $roles->findBySlug('admin');

        if (!in_array($admin->getKey(), $value)) {
            return true;
        }

        if (!$authorizer->authorize('anomaly.module.users::users.write_admins')) {
            return false;
        }

        return true;
    }
}
