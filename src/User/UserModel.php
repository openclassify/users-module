<?php

namespace Anomaly\UsersModule\User;

use Illuminate\Auth\Authenticatable;
use Anomaly\UsersModule\Role\RoleModel;
use Illuminate\Notifications\Notifiable;
use Anomaly\UsersModule\Role\RolePresenter;
use Anomaly\UsersModule\Role\RoleCollection;
use Anomaly\UsersModule\Role\Command\GetRole;
use Illuminate\Auth\Passwords\CanResetPassword;
use Illuminate\Support\Collection;
use Anomaly\Streams\Platform\Model\Traits\Streams;
use Anomaly\UsersModule\User\Contract\UserInterface;
use Anomaly\Streams\Platform\User\Contract\RoleInterface;
use Illuminate\Foundation\Auth\Access\Authorizable;
use Illuminate\Database\Eloquent\Model;

/**
 * Class UserModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class UserModel extends Model implements UserInterface, \Illuminate\Contracts\Auth\Authenticatable
{
    use Streams;
    use Notifiable;
    use Authorizable;
    use Authenticatable;
    use CanResetPassword;

    /**
     * The entry table.
     *
     * @var string
     */
    protected $table = 'users_users';

    /**
     * The cast types.
     *
     * @var array
     */
    protected $casts = [
        'created_at'       => 'datetime',
        'updated_at'       => 'datetime',
        'deleted_at'       => 'datetime',
        'last_login_at'    => 'datetime',
        'last_activity_at' => 'datetime',
    ];

    /**
     * The stream definition.
     *
     * @var array
     */
    protected static $stream = [
        'slug'         => 'users',
        'title_column' => 'display_name',
        'trashable'    => true,
        'versionable'  => true,
        'searchable'   => true,
        'config' => [
            'policy' => UserPolicy::class,
        ],
        'fields' => [
            'str_id'        => [
                'required' => true,
                'unique'   => true,
                'type'     => 'anomaly.field_type.text',
            ],
            'email'        => [
                'required' => true,
                'unique'   => true,
                'type'     => 'anomaly.field_type.email',
            ],
            'username'     => [
                'required' => true,
                'unique'   => true,
                'type'   => 'anomaly.field_type.slug',
                'config' => [
                    'type'      => '_',
                    'lowercase' => false,
                ],
            ],
            'password'     => [
                'required' => true,
                'type'   => 'anomaly.field_type.text',
                'config' => [
                    'type' => 'password',
                ],
            ],
            'roles'        => [
                'required' => true,
                'type'   => 'anomaly.field_type.multiple',
                'config' => [
                    'related' => RoleModel::class,
                ],
            ],
            'display_name' => [
                'required' => true,
                'type' => 'anomaly.field_type.text',
            ],
            'first_name'       => 'anomaly.field_type.text',
            'last_name'        => 'anomaly.field_type.text',
            'activated'        => 'anomaly.field_type.boolean',
            'enabled'          => 'anomaly.field_type.boolean',
            'permissions'      => 'anomaly.field_type.checkboxes',
            'remember_token'   => 'anomaly.field_type.text',
            'activation_code'  => 'anomaly.field_type.text',
            'reset_code'       => 'anomaly.field_type.text',
            'last_login_at'    => 'anomaly.field_type.datetime',
            'last_activity_at' => 'anomaly.field_type.datetime',
            'ip_address'       => 'anomaly.field_type.text',
        ],
    ];

    /**
     * Guarded attributes.
     *
     * @var array
     */
    protected $guarded = [
        'password',
    ];

    /**
     * The roles relation
     *
     * @return Relation
     */
    public function roles()
    {
        return $this->stream()->fields->roles->type()->setEntry($this)->getRelation();
    }

    /**
     * Get the string ID.
     *
     * @return string
     */
    public function getStrId()
    {
        return $this->str_id;
    }

    /**
     * Get the email.
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Get the username.
     *
     * @return string
     */
    public function getUsername()
    {
        return $this->username;
    }

    /**
     * Get the display name.
     *
     * @return string
     */
    public function getDisplayName()
    {
        return $this->display_name;
    }

    /**
     * Return whether a user is in any of the provided roles.
     *
     * @param $roles
     * @return bool
     */
    public function hasAnyRole($roles)
    {
        if (!$roles) {
            return false;
        }

        if ($roles instanceof Collection) {
            $roles = $roles->all();
        }

        foreach ($roles as $role) {
            if ($this->hasRole($role)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return whether a user is in a role.
     *
     * @param RoleInterface|RolePresenter|string $role
     * @return bool
     */
    public function hasRole($role)
    {
        if (!is_object($role)) {
            $role = dispatch_now(new GetRole($role));
        }

        if (!$role) {
            return false;
        }

        /* @var RoleInterface $role */
        foreach ($roles = $this->getRoles() as $attached) {
            if ($attached->getKey() === $role->getKey()) {
                return true;
            }
        }

        return false;
    }

    /**
     * Get related roles.
     *
     * @return RoleCollection
     */
    public function getRoles()
    {
        return $this->roles;
    }

    /**
     * Return whether a user has any of provided permission.
     *
     * @param array $permissions
     * @param bool $checkRoles
     * @return bool
     */
    public function hasAnyPermission(array $permissions, $checkRoles = true)
    {
        foreach ($permissions as $permission) {
            if ($this->hasPermission($permission, $checkRoles)) {
                return true;
            }
        }

        return false;
    }

    /**
     * Return whether a user or it's roles has a permission.
     *
     * @param        $permission
     * @param  bool $checkRoles
     * @return mixed
     */
    public function hasPermission($permission, $checkRoles = true)
    {
        if (!$permission) {
            return true;
        }

        if (in_array($permission, $this->getPermissions())) {
            return true;
        }

        if ($checkRoles) {

            /* @var RoleInterface $role */
            foreach ($this->getRoles() as $role) {
                if ($role->hasPermission($permission) || $role->getSlug() === 'admin') {
                    return true;
                }
            }
        }

        return false;
    }

    /**
     * Get the permissions.
     *
     * @return array
     */
    public function getPermissions()
    {
        return (array) $this->permissions;
    }

    /**
     * Hash the password whenever setting it.
     *
     * @param $password
     */
    public function setPasswordAttribute($password)
    {
        array_set($this->attributes, 'password', app('hash')->make($password));
    }

    /**
     * Return whether the model is deletable or not.
     *
     * @return bool
     */
    public function isDeletable()
    {
        // You can't delete yourself.
        if ($this->getKey() == app('auth')->id()) {
            return false;
        }

        // Only admins can delete admins
        if (!app('auth')->user()->isAdmin() && $this->isAdmin()) {
            return false;
        }

        return true;
    }

    /**
     * Return whether the user is an admin or not.
     *
     * @return bool
     */
    public function isAdmin()
    {
        /* @var RoleInterface $role */
        foreach ($this->getRoles() as $role) {
            if ($role->getSlug() === 'admin') {
                return true;
            }
        }

        return false;
    }

    /**
     * Return the enabled flag.
     *
     * @return bool
     */
    public function isEnabled()
    {
        return $this->enabled;
    }

    /**
     * Get the reset code.
     *
     * @return string
     */
    public function getResetCode()
    {
        return $this->reset_code;
    }

    /**
     * Get the activation code.
     *
     * @return string
     */
    public function getActivationCode()
    {
        return $this->activation_code;
    }

    /**
     * Return the full name.
     *
     * @return string
     */
    public function name()
    {
        return "{$this->getFirstName()} {$this->getLastName()}";
    }

    /**
     * Get the first name.
     *
     * @return string
     */
    public function getFirstName()
    {
        return $this->first_name;
    }

    /**
     * Get the last name.
     *
     * @return string
     */
    public function getLastName()
    {
        return $this->last_name;
    }

    /**
     * Attach a role to the user.
     *
     * @param RoleInterface $role
     */
    public function attachRole(RoleInterface $role)
    {
        $this->roles()->attach($role);
    }

    /**
     * Detach a role from the user
     *
     * @param RoleInterface $role
     */
    public function detachRole(RoleInterface $role)
    {
        $this->roles()->detach($role);
    }

    /**
     * Route notifications for the Slack channel.
     *
     * @return string
     */
    public function routeNotificationForSlack()
    {
        return env('SLACK_WEBHOOK');
    }

    /**
     * Return the model as a searchable array.
     *
     * @return array
     */
    public function toSearchableArray()
    {
        $array = parent::toSearchableArray();

        array_pull($array, 'password');

        return $array;
    }

    /**
     * Return if the model should
     * be searchable or not.
     *
     * @return bool
     */
    public function shouldBeSearchable()
    {
        return $this->isActivated();
    }

    /**
     * Return the activated flag.
     *
     * @return bool
     */
    public function isActivated()
    {
        return $this->activated;
    }
}
