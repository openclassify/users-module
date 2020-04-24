<?php

namespace Anomaly\UsersModule\Support\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * Class Authorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Authorizer extends Facade
{

    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return 'authorizer';
    }
}
