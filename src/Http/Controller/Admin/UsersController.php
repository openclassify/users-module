<?php

namespace Anomaly\UsersModule\Http\Controller\Admin;

use Illuminate\Support\Facades\Auth;
use Anomaly\UsersModule\User\UserPassword;
use Anomaly\Streams\Platform\Support\Authorizer;
use Anomaly\UsersModule\User\Form\UserFormBuilder;
use Anomaly\UsersModule\User\Table\UserTableBuilder;
use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Anomaly\UsersModule\User\Ability\AbilityFormBuilder;
use Anomaly\UsersModule\User\Impersonation\ImpersonationFormBuilder;

/**
 * Class UsersController
 *
 * This is the primary class for managing
 * users through the UI.
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class UsersController extends AdminController
{

    /**
     * Return an index of existing users.
     *
     * @param  UserTableBuilder $table
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function index(UserTableBuilder $table)
    {
        return $table->render();
    }

    /**
     * Return the form for creating a new user.
     *
     * @param  UserFormBuilder $form
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function create(UserFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Return the form for editing an existing user.
     *
     * @param  UserFormBuilder                            $form
     * @param                                             $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function edit(UserFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    /**
     * Return the form for editing abilities.
     *
     * @param  AbilityFormBuilder                      $form
     * @param                                             $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function abilities(AbilityFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    /**
     * Return the form for user impersonation.
     *
     * @param ImpersonationFormBuilder $form
     * @param UserRepositoryInterface  $users
     * @param                          $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function impersonate(ImpersonationFormBuilder $form, UserRepositoryInterface $users, $id)
    {
        /* @var UserInterface $user */
        if (!$user = $users->find($id)) {
            abort(404);
        }

        if ($user->isAdmin()) {
            $this->messages->error('anomaly.module.users::error.impersonate_admins');

            return back();
        }

        return $form
            ->setUser($user)
            ->render($id);
    }

    /**
     * Initiate a user reset.
     *
     * @param Authorizer              $authorizer
     * @param UserPassword            $password
     * @param UserRepositoryInterface $users
     * @param                         $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function reset(Authorizer $authorizer, UserPassword $password, UserRepositoryInterface $users, $id)
    {
        if (!$authorizer->authorize('anomaly.module.users::users.reset')) {
            abort(403);
        }

        /* @var UserInterface $user */
        if (!$user = $users->find($id)) {
            abort(404);
        }

        if ($user->isAdmin()) {
            $this->messages->error('anomaly.module.users::error.reset_admins');

            return back();
        }

        $password->invalidate($user);

        $this->messages->success('anomaly.module.users::success.reset_user');

        return back();
    }

    /**
     * Redirect to a user's profile.
     *
     * @param UserRepositoryInterface $users
     * @param                         $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function view(UserRepositoryInterface $users, $id)
    {
        /* @var UserInterface $user */
        if (!$user = $users->find($id)) {
            abort(404);
        }

        return redirect($user->route('view'));
    }
}
