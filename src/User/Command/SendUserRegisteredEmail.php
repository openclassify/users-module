<?php namespace Anomaly\UsersModule\User\Command;

use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\UsersModule\User\Notification\ActivateYourAccount;
use Illuminate\Notifications\Notifiable;

/**
 * Class SendUserRegisteredEmail
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class SendUserRegisteredEmail
{

    /**
     * The user instance.
     *
     * @var UserInterface|Notifiable
     */
    protected $user;

    /**
     * The redirect path.
     *
     * @var string
     */
    protected $redirect;

    /**
     * Create a new SendUserRegisteredEmail instance.
     *
     * @param UserInterface|Notifiable $user
     * @param string $redirect
     */
    public function __construct(UserInterface $user, $redirect = '/')
    {
        $this->user     = $user;
        $this->redirect = $redirect;
    }

    /**
     * Handle the command.
     *
     * @return bool
     */
    public function handle()
    {
        $this->user->notify(new ActivateYourAccount($this->redirect));
    }
}
