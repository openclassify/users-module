<?php

namespace Anomaly\UsersModule\Role;

use Anomaly\UsersModule\Role\RoleModel;
use Anomaly\UsersModule\User\UserModel;

/**
 * Class Role
 *
 * @link   http://pyrocms.com/
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RolePolicy
{

    /**
     * Determine whether the user can view any anomaly users module user user models.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @return mixed
     */
    public function viewAny(UserModel $user)
    {
        //
    }

    /**
     * Determine whether the user can view the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @param  \Anomaly\UsersModule\User\UserModel
     * @return mixed
     */
    public function view(UserModel $user, RoleModel $model)
    {
        //
    }

    /**
     * Determine whether the user can create anomaly users module user user models.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @return mixed
     */
    public function create(UserModel $user)
    {
        //
    }

    /**
     * Determine whether the user can update the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel $user
     * @param  \Anomaly\UsersModule\Role\RoleModel $model
     * @return mixed
     */
    public function update(UserModel $user, RoleModel $model)
    {
        dd('Hi (Roles)');
        //
    }

    /**
     * Determine whether the user can delete the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @param  \Anomaly\UsersModule\User\UserModel
     * @return mixed
     */
    public function delete(UserModel $user, UserModel $model)
    {
        //
    }

    /**
     * Determine whether the user can restore the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @param  \Anomaly\UsersModule\User\UserModel
     * @return mixed
     */
    public function restore(UserModel $user, UserModel $model)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @param  \Anomaly\UsersModule\User\UserModel
     * @return mixed
     */
    public function forceDelete(UserModel $user, UserModel $model)
    {
        //
    }
}
