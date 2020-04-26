<?php namespace Anomaly\UsersModule\Role\Ability;

use Anomaly\Streams\Platform\Model\EloquentModel;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;
use Illuminate\Routing\Redirector;

/**
 * Class AbilityFormHandler
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class AbilityFormHandler
{

    /**
     * Handle the form.
     *
     * @param AbilityFormBuilder   $builder
     * @param RoleRepositoryInterface $roles
     * @param Redirector              $redirect
     */
    public function handle(AbilityFormBuilder $builder, RoleRepositoryInterface $roles, Redirector $redirect)
    {
        /* @var RoleInterface|EloquentModel $role */
        $role = $builder->getEntry();

        $roles->save($role->setAttribute('abilities', array_filter(array_flatten($builder->getFormInput()))));

        $builder->setFormResponse($redirect->refresh());
    }
}
