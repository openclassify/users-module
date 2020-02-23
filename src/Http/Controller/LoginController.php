<?php

namespace Anomaly\UsersModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\UsersModule\User\UserAuthenticator;

/**
 * Class LoginController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class LoginController extends PublicController
{

    /**
     * Return the login form.
     *
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     * @internal param Guard $auth
     */
    public function login()
    {
        if (auth()->check()) {
            return redirect(request('redirect', '/'));
        }

        return view('anomaly.module.users::login');
    }

    /**
     * Logout the active user.
     *
     * @param  UserAuthenticator $authenticator
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(UserAuthenticator $authenticator)
    {
        if (!auth()->guest()) {
            $authenticator->logout();
        }

        messages('success', request('message', 'anomaly.module.users::message.logged_out'));

        return redirect(url(request('redirect', '/')));
    }
}
