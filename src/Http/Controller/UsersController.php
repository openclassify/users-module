<?php namespace Anomaly\UsersModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;

/**
 * Class UsersController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class UsersController extends PublicController
{

    /**
     * Redirect the current user
     * to their profile route.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function self()
    {
        /* @var UserInterface $user */
        if (!$user = user()) {
            abort(404);
        }

        return redirect($user->route('view'));
    }

    /**
     * View a user profile.
     *
     * @param UserRepositoryInterface $users
     * @param $username
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function view(UserRepositoryInterface $users, $username)
    {
        if (!$user = $users->findByUsername($username)) {
            abort(404);
        }

        return view('anomaly.module.users::users/view', compact('user'));
    }
}
