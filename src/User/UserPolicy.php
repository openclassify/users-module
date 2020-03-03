<?php

namespace Anomaly\UsersModule\User;

use Anomaly\UsersModule\User\UserModel;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any anomaly users module user user models.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @return mixed
     */
    public function viewAny(UserModel $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @param  \Anomaly\UsersModule\User\UserModel
     * @return mixed
     */
    public function view(UserModel $user, UserModel $model)
    {
        return true;
    }

    /**
     * Determine whether the user can create anomaly users module user user models.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @return mixed
     */
    public function create(UserModel $user)
    {
        return true;
    }

    /**
     * Determine whether the user can update the anomaly users module user user model.
     *
     * @param  \Anomaly\UsersModule\User\UserModel  $user
     * @param  \Anomaly\UsersModule\User\UserModel
     * @return mixed
     */
    public function update(UserModel $user, UserModel $model)
    {
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
