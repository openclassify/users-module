<?php

namespace Anomaly\UsersModule\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Anomaly\UsersModule\Support\Authorizer;
use Anomaly\Streams\Platform\Message\MessageManager;
use Anomaly\Streams\Platform\User\Contract\UserInterface;

/**
 * Class AuthorizeRoutePermission
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AuthorizeRoutePermission
{

    /**
     * The message bag.
     *
     * @var MessageManager
     */
    protected $messages;

    /**
     * The authorizer utility.
     *
     * @var Authorizer
     */
    protected $authorizer;

    /**
     * Create a new AuthorizeModuleAccess instance.
     *
     * @param MessageManager $messages
     * @param Authorizer $authorizer
     */
    public function __construct(MessageManager $messages, Authorizer $authorizer)
    {
        $this->messages   = $messages;
        $this->authorizer = $authorizer;
    }

    /**
     * Check the authorization of module access.
     *
     * @param  Request $request
     * @param  \Closure $next
     * @return \Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if (in_array($request->path(), ['admin/login', 'admin/logout'])) {
            return $next($request);
        }

        if (
            $request->segment(1) == 'admin' && !$this->authorizer->authorize(
                'streams::general.control_panel'
            )
        ) {
            abort(403);
        }

        /**
         * Check if the user is an admin.
         *
         * @var UserInterface $user
         */
        if (($user = auth()->user()) && $user->isAdmin()) {
            return $next($request);
        }

        $permission = (array) array_get(request()->route()->getAction(), 'anomaly.module.users::permission');

        if ($permission && !$this->authorizer->authorizeAny($permission, null, true)) {
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
