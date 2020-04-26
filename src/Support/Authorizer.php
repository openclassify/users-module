<?php

namespace Anomaly\UsersModule\Support;

use Illuminate\Database\Eloquent\Collection;

/**
 * Class Authorizer
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class Authorizer
{

    /**
     * The guest role.
     *
     * @var RoleInterface
     */
    protected $guest;

    /**
     * Authorize a user against a ability.
     *
     * @param $ability
     * @param null $user
     * @return bool
     */
    public function authorize($ability, $user = null)
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            $user = request()->user();
        }

        if (!$user && $guest = $this->getGuest()) {
            return $guest->hasAbility($ability);
        }

        if (!$user) {
            return false;
        }

        return $this->checkAbility($ability, $user);
    }

    /**
     * Authorize a user against any ability.
     *
     * @param  array $abilities
     * @param  $user
     * @param  bool $strict
     * @return bool
     */
    public function authorizeAny(array $abilities, $user = null, $strict = false)
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            return !$strict;
        }

        foreach ($abilities as $ability) {
            if ($this->checkAbility($ability, $user)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Authorize a user against all ability.
     *
     * @param  array $abilities
     * @param  $user
     * @param  bool $strict
     * @return bool
     */
    public function authorizeAll(array $abilities, $user = null, $strict = false)
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            return !$strict;
        }

        foreach ($abilities as $ability) {
            if (!$this->checkAbility($ability, $user)) {
                return false;
            }
        }

        return true;
    }

    /**
     * Return a user's ability.
     *
     * @param                $ability
     * @param  $user
     * @return bool
     */
    protected function checkAbility($ability, $user)
    {
        /*
         * No ability, let it proceed.
         */
        if (!$ability) {
            return true;
        }

        /*
         * If the ability does not actually exist
         * then we cant really do anything with it.
         */
        if (str_is('*::*.*', $ability) && !ends_with($ability, '*')) {
            $parts = explode('.', str_replace('::', '.', $ability));
            $end   = array_pop($parts);
            $group = array_pop($parts);
            $parts = explode('::', $ability);

            // If it does not exist, we are authorized.
            if (!in_array($end, (array) config($parts[0] . '::abilities.' . $group))) {
                return true;
            }
        } elseif (ends_with($ability, '*')) {
            $parts = explode('::', $ability);

            $addon = array_shift($parts);

            /*
             * Check vendor.module.slug::group.*
             * then check vendor.module.slug::*
             */
            if (str_is('*.*.*::*.*.*', $ability)) {
                $end = trim(substr($ability, strpos($ability, '::') + 2), '.*');

                if (!$abilities = config($addon . '::abilities.' . $end)) {
                    return true;
                } else {
                    return $user->hasAnyAbility($abilities);
                }
            } elseif (str_is('*.*.*::*.*', $ability)) {
                $end = trim(substr($ability, strpos($ability, '::') + 2), '.*');

                if (!$abilities = config($addon . '::abilities.' . $end)) {
                    return true;
                } else {
                    $check = [];

                    foreach ($abilities as &$ability) {
                        $check[] = $addon . '::' . $end . '.' . $ability;
                    }

                    return $user->hasAnyAbility($check);
                }
            } else {
                if (!$abilities = config($addon . '::abilities')) {
                    return true;
                } else {
                    $check = [];

                    foreach ($abilities as $group => &$ability) {
                        foreach ($ability as $access) {
                            $check[] = $addon . '::' . $group . '.' . $access;
                        }
                    }

                    return $user->hasAnyAbility($check);
                }
            }
        }

        // Check if the user actually has ability.
        if (!$user || !$user->hasAbility($ability)) {
            return false;
        }

        return true;
    }

    /**
     * Authorize a user against a role.
     *
     * @param RoleInterface $role
     * @param  $user
     * @return bool
     */
    public function authorizeRole(RoleInterface $role, $user = null)
    {
        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            $user = request()->user();
        }

        if ($this->isGuest($role)) {
            return $user ? false : true;
        }

        if (!$user) {
            return false;
        }

        return $user->hasRole($role);
    }

    /**
     * Authorize a user against any role.
     *
     * @param Collection $roles
     * @param  $user
     * @return bool
     */
    public function authorizeAnyRole(Collection $roles, $user = null)
    {
        if ($roles->isEmpty()) {
            return true;
        }

        if (!$user) {
            $user = auth()->user();
        }

        if (!$user) {
            $user = request()->user();
        }

        if (!$user) {
            return false;
        }

        return $user->hasAnyRole($roles);
    }

    /**
     * Get the guest role.
     *
     * @return RoleInterface
     */
    public function getGuest()
    {
        return $this->guest;
    }

    /**
     * Set the guest role.
     *
     * @param  RoleInterface $guest
     * @return $this
     */
    public function setGuest(RoleInterface $guest)
    {
        $this->guest = $guest;

        return $this;
    }

    /**
     * Return whether a role is
     * the guest role or not.
     *
     * @param RoleInterface $role
     * @return bool
     */
    public function isGuest(RoleInterface $role)
    {
        $guest = $this->getGuest();

        return $guest->getSlug() === $role->getSlug();
    }
}
