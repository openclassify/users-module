<?php namespace Anomaly\UsersModule\User;

use Anomaly\UsersModule\User\Command\ActivateUserByCode;
use Anomaly\UsersModule\User\Command\ActivateUserByForce;
use Anomaly\UsersModule\User\Command\SendActivationEmail;
use Anomaly\UsersModule\User\Command\StartUserActivation;
use Anomaly\UsersModule\User\Contract\UserInterface;

/**
 * Class UserActivator
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class UserActivator
{

    /**
     * Start a user activation process.
     *
     * @param  UserInterface $user
     * @return bool
     */
    public function start(UserInterface $user)
    {
        return dispatch_now(new StartUserActivation($user));
    }

    /**
     * Activate a user by code.
     *
     * @param UserInterface $user
     * @param $code
     * @return mixed
     */
    public function activate(UserInterface $user, $code)
    {
        return dispatch_now(new ActivateUserByCode($user, $code));
    }

    /**
     * Activate a user by force.
     *
     * @param  UserInterface $user
     * @return bool
     */
    public function force(UserInterface $user)
    {
        return dispatch_now(new ActivateUserByForce($user));
    }

    /**
     * Send an activation email.
     *
     * @param  UserInterface $user
     * @param  string $redirect
     * @return bool
     */
    public function send(UserInterface $user, $redirect = '/')
    {
        return dispatch_now(new SendActivationEmail($user, $redirect));
    }
}
