<?php namespace Anomaly\UsersModule\User\Command;


/**
 * Class GetLogoutPath
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class GetLogoutPath
{

    /**
     * Handle the command.
     *
     * @return string
     */
    public function handle()
    {
        return config('anomaly.module.users::paths.logout');
    }
}
