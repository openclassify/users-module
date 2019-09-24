<?php namespace Anomaly\UsersModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\PublicController;
use Anomaly\UsersModule\User\Register\Command\HandleActivateRequest;

/**
 * Class RegisterController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RegisterController extends PublicController
{

    /**
     * Return the register view.
     *
     * @return \Illuminate\Contracts\View\View|mixed
     */
    public function register()
    {
        share(
            'meta_title',
            trans('anomaly.module.users::breadcrumb.register')
        );

        return view('anomaly.module.users::register');
    }

    /**
     * Activate a registered user.
     *
     * @return \Illuminate\Http\RedirectResponse
     */
    public function activate()
    {
        if (!dispatch_now(new HandleActivateRequest())) {
            $this->messages->error('anomaly.module.users::error.activate_user');

            return redirect('/');
        }

        $this->messages->success('anomaly.module.users::success.activate_user');
        $this->messages->success('anomaly.module.users::message.logged_in');

        return redirect(request('redirect', '/'));
    }
}
