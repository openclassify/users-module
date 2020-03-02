<?php namespace Anomaly\UsersModule\Http\Middleware;

use Anomaly\Streams\Platform\Message\MessageManager;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Closure;
use Illuminate\Http\Request;

/**
 * Class AuthorizeRouteRoles
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeRouteRoles
{

    /**
     * The message bag.
     *
     * @var MessageManager
     */
    protected $messages;

    /**
     * Create a new AuthorizeModuleAccess instance.
     *
     * @param MessageManager $messages
     */
    public function __construct(MessageManager $messages)
    {
        $this->messages = $messages;
    }

    /**
     * Check the authorization of module access.
     *
     * @param  \Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->path(), ['admin/login', 'admin/logout'])) {
            return $next($request);
        }

        /* @var UserInterface $user */
        $user = user();
        $role = (array)array_get(request()->route()->getAction(), 'anomaly.module.users::role');

        /**
         * Check if the user is an admin.
         */
        if ($user && $user->isAdmin()) {
            return $next($request);
        }

        /**
         * If the guest role is desired
         * then pass through if no user.
         */
        if ($role && in_array('guest', $role) && !$user) {
            return $next($request);
        }

        if ($role && (!$user || !$user->hasAnyRole($role))) {
            $redirect = array_get(request()->route()->getAction(), 'anomaly.module.users::redirect');
            $intended = array_get(request()->route()->getAction(), 'anomaly.module.users::intended');
            $message  = array_get(request()->route()->getAction(), 'anomaly.module.users::message');

            if ($message) {
                $this->messages->error($message);
            }

            if ($intended !== false) {
                session(['url.intended' => $request->fullUrl()]);
            }

            if ($redirect) {
                return redirect($redirect);
            }

            $route = array_get(request()->route()->getAction(), 'anomaly.module.users::route');

            if ($route) {
                return redirect()->route($route);
            }

            abort(403);
        }

        return $next($request);
    }
}
