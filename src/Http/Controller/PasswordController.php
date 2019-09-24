<?php namespace Anomaly\UsersModule\Http\Controller;

use Anomaly\Streams\Platform\Http\Controller\PublicController;

/**
 * Class PasswordController
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PasswordController extends PublicController
{

    /**
     * Return a forgot password view.
     */
    public function forgot()
    {
        share(
            'meta_title',
            trans('anomaly.module.users::breadcrumb.reset_password')
        );

        return view('anomaly.module.users::password/forgot');
    }

    /**
     * Reset a user password.
     *
     * @return \Illuminate\Contracts\View\View|mixed
     */
    public function reset()
    {
        share(
            'meta_title',
            trans('anomaly.module.users::breadcrumb.reset_password')
        );

        return view('anomaly.module.users::password/reset');
    }
}
