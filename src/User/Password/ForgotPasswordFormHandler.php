<?php namespace Anomaly\UsersModule\User\Password;

use Anomaly\Streams\Platform\Message\MessageManager;
use Anomaly\UsersModule\User\Contract\UserRepositoryInterface;
use Anomaly\UsersModule\User\UserPassword;

/**
 * Class ForgotPasswordFormHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ForgotPasswordFormHandler
{

    /**
     * Handle the form.
     *
     * @param ForgotPasswordFormBuilder $builder
     * @param UserRepositoryInterface $users
     * @param UserPassword $password
     * @param MessageManager $messages
     */
    public function handle(
        ForgotPasswordFormBuilder $builder,
        UserRepositoryInterface $users,
        UserPassword $password,
        MessageManager $messages
    ) {
        if ($builder->hasFormErrors()) {
            return;
        }

        $user = $users->findByEmail($builder->getFormValue('email'));

        if ($path = $builder->getFormOption('reset_path')) {
            config(['anomaly.module.users::paths.reset' => $path]);
        }

        $password->forgot($user);
        $password->send($user, $builder->getFormOption('reset_redirect'));

        $messages->success($builder->getFormOption('success_message'));
    }
}
