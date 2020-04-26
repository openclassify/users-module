<?php namespace Anomaly\UsersModule\User\Ability;

use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
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
     * @param UserRepositoryInterface $users
     * @param Redirector              $redirect
     */
    public function handle(
        AbilityFormBuilder $builder,
        UserRepositoryInterface $users,
        Redirector $redirect
    ) {
        /* @var UserInterface|EloquentModel $user */
        $user = $builder->getEntry();

        $users->save(
            $user->setAttribute(
                'abilities',
                array_filter(array_flatten($builder->getFormInput()))
            )
        );

        $builder->setFormResponse($redirect->refresh());
    }
}
