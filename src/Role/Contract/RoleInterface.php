<?php

namespace Anomaly\UsersModule\Role\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\UsersModule\User\UserCollection;

/**
 * Interface RoleInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
interface RoleInterface extends EntryInterface
{

    /**
     * Get the role's slug.
     *
     * @return string
     */
    public function getSlug();

    /**
     * Get the role's name.
     *
     * @return string
     */
    public function getName();

    /**
     * Get the role's abilities.
     *
     * @return array
     */
    public function getAbilities();

    /**
     * Return if a role as access to a the ability.
     *
     * @param  string $ability
     * @return bool
     */
    public function hasAbility($ability);

    /**
     * Get the related users.
     *
     * @return UserCollection
     */
    public function getUsers();

    /**
     * Return the users relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users();
}
