<?php namespace Anomaly\UsersModule\User\Table\View;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;

/**
 * Class OnlineQuery
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class OnlineQuery
{

    /**
     * Handle the query.
     *
     * @param Builder $query
     */
    public function handle(Builder $query)
    {
        $query
            ->where('last_activity_at', '>', new Carbon('-10 minutes'))
            ->where('id', '!=', auth()->id());
    }
}
