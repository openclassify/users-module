<?php namespace Anomaly\UsersModule\User\Impersonation;

use Illuminate\Routing\Redirector;
use Illuminate\Translation\Translator;
use Anomaly\UsersModule\User\UserAuthenticator;
use Anomaly\Streams\Platform\Message\MessageBag;

/**
 * Class ImpersonationFormHandler
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ImpersonationFormHandler
{

    /**
     * @param ImpersonationFormBuilder $builder
     * @param UserAuthenticator        $authenticator
     * @param Translator               $translator
     * @param Redirector               $redirector
     * @param MessageBag               $messages
     */
    public function handle(
        ImpersonationFormBuilder $builder,
        UserAuthenticator $authenticator,
        Translator $translator,
        Redirector $redirector,
        MessageBag $messages
    ) {
        $authenticator->login($user = $builder->getUser());

        $messages->success(
            $translator->trans(
                'anomaly.module.users::message.impersonating',
                [
                    'username' => $user->getUsername(),
                ]
            )
        );

        $builder->setSave(false);

        $builder->setFormResponse($redirector->to('/'));
    }
}
