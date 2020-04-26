<?php namespace Anomaly\UsersModule\User\Contract;

use Anomaly\Streams\Platform\Entry\Contract\EntryInterface;
use Anomaly\Streams\Platform\User\Contract\RoleInterface;
use Anomaly\UsersModule\Role\RoleCollection;
use Anomaly\UsersModule\Role\RolePresenter;

/**
 * Interface UserInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
interface UserInterface extends EntryInterface
{

    /**
     * Get the string ID.
     *
     * @return string
     */
    public function getStrId();

    /**
     * Get the email.
     *
     * @return string
     */
    public function getEmail();

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername();

    /**
     * Get the display name.
     *
     * @return string
     */
    public function getDisplayName();

    /**
     * Get the first name.
     *
     * @return string
     */
    public function getFirstName();

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getLastName();

    /**
     * Get related roles.
     *
     * @return RoleCollection
     */
    public function getRoles();

    /**
     * Return whether a user is in a role.
     *
     * @param RoleInterface|RolePresenter|string $role
     * @return bool
     */
    public function hasRole($role);

    /**
     * Return whether a user is in
     * any of the provided roles.
     *
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles);

    /**
     * Return whether the user
     * is an admin or not.
     *
     * @return bool
     */
    public function isAdmin();

    /**
     * Get the abilities.
     *
     * @return array
     */
    public function getAbilities();

    /**
     * Return whether a user or it's roles has a ability.
     *
     * @param        $ability
     * @param  bool $checkRoles
     * @return mixed
     */
    public function hasAbility($ability, $checkRoles = true);

    /**
     * Return whether a user has any of provided ability.
     *
     * @param $abilities
     * @return bool
     */
    public function hasAnyAbility(array $abilities);

    /**
     * Return the activated flag.
     *
     * @return bool
     */
    public function isActivated();

    /**
     * Return the enabled flag.
     *
     * @return bool
     */
    public function isEnabled();

    /**
     * Get the reset code.
     *
     * @return string
     */
    public function getResetCode();

    /**
     * Get the activation code.
     *
     * @return string
     */
    public function getActivationCode();

    /**
     * Return the full name.
     *
     * @return string
     */
    public function name();

    /**
     * Attach a role to the user.
     *
     * @param RoleInterface $role
     */
    public function attachRole(RoleInterface $role);

    /**
     * Detach a role from the user
     *
     * @param RoleInterface $role
     */
    public function detachRole(RoleInterface $role);
}
