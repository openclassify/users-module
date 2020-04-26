<?php namespace Anomaly\UsersModule\Role;

use Illuminate\Support\Collection;
use Anomaly\UsersModule\Role\Contract\RoleInterface;

/**
 * Class RoleCollection
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RoleCollection extends Collection
{

    /**
     * Return all abilities.
     *
     * @return array
     */
    public function abilities()
    {
        return $this->map(
            function (RoleInterface $role) {
                return $role->getAbilities();
            }
        )->flatten()->all();
    }

    /**
     * Return if a role as access to a the ability.
     *
     * @param  string $ability
     * @return RoleCollection
     */
    public function hasAbility($ability)
    {
        return $this->filter(
            function (RoleInterface $role) use ($ability) {
                return $role->hasAbility($ability);
            }
        );
    }

    /**
     * Return if the role exists or not.
     *
     * @param $role
     * @return bool
     */
    public function hasRole($role)
    {
        return (bool)$this->first(
            function ($item) use ($role) {

                /* @var RoleInterface $item */
                return $item->getSlug() == $role;
            }
        );
    }
}
