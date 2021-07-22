<?php namespace Anomaly\UsersModule\User\Validation;

use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\UserAuthenticator;

/**
 * Class ValidateAuthentication
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class ValidateAuthentication
{

    /**
     * Handle the validation.
     *
     * @param UserAuthenticator $authenticator
     * @param $value
     * @return UserInterface|bool
     */
    public function handle(UserAuthenticator $authenticator, $value)
    {
        /* @var UserInterface $user */
        $user = auth()->user();

        return $authenticator->attempt(
            [
                'email'    => $user->getEmail(),
                'password' => $value,
            ]
        );
    }
}
