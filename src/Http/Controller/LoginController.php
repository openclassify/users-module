<?php namespace Anomaly\UsersModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\Streams\Platform\Routing\UrlGenerator;
use Anomaly\Streams\Platform\View\ViewTemplate;
use Anomaly\UsersModule\User\UserAuthenticator;
use Illuminate\Contracts\Auth\Guard;

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
     * @param ViewTemplate $template
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\RedirectResponse|mixed
     * @internal param Guard $auth
     */
    public function login(ViewTemplate $template)
    {
        if (auth()->check()) {
            return redirect(request('redirect', '/'));
        }

        // @todo need to figure out variables
        $template->set(
            'meta_title',
            trans('anomaly.module.users::breadcrumb.login')
        );

        return view('anomaly.module.users::login');
    }

    /**
     * Logout the active user.
     *
     * @param  UserAuthenticator $authenticator
     * @param  Guard $auth
     * @return \Illuminate\Http\RedirectResponse
     */
    public function logout(UserAuthenticator $authenticator, Guard $auth, UrlGenerator $url)
    {
        if (!$auth->guest()) {
            $authenticator->logout();
        }

        $this->messages->success($this->request->get('message', 'anomaly.module.users::message.logged_out'));

        return $this->response->redirectTo($this->url->to($this->request->get('redirect', '/')));
    }
}
