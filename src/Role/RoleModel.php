<?php

namespace Anomaly\UsersModule\Role;

use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\User\Contract\RoleInterface as StreamsRole;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Anomaly\UsersModule\User\UserCollection;

/**
 * Class RoleModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RoleModel extends EntryModel implements RoleInterface, StreamsRole
{

    use \Illuminate\Database\Eloquent\SoftDeletes;

    protected $searchable = false;

    protected $versionable = false;

    protected $table = 'users_roles';

    protected $titleName = 'name';

    protected $fields = [
        'name',
        'slug',
        'description',
        'permissions',
    ];

    protected $with = [];

    protected $dates = ['created_at', 'updated_at', 'deleted_at'];

    protected $relationships = [];

    // @todo put this in $translated and use !empty for isTranslatable.
    protected $translatedAttributes = ['name', 'description'];

    protected $stream = 'users.roles';

    /**
     * Get the role name.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Return if a role as access to a the permission.
     *
     * @param  string $permission
     * @return mixed
     */
    public function hasPermission($permission)
    {
        if ($this->getSlug() == 'admin') {
            return true;
        }

        if (!$this->getPermissions()) {
            return false;
        }

        if (in_array($permission, $this->getPermissions())) {
            return true;
        }

        return false;
    }

    /**
     * Get the role slug.
     *
     * @return string
     */
    public function getSlug()
    {
        return $this->slug;
    }

    /**
     * Get the role's permissions.
     *
     * @return array
     */
    public function getPermissions()
    {
        return $this->permissions;
    }

    /**
     * Get the related users.
     *
     * @return UserCollection
     */
    public function getUsers()
    {
        return $this->users;
    }

    /**
     * Return the users relation.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function users()
    {
        return $this->belongsToMany(
            'Anomaly\UsersModule\User\UserModel',
            'users_users_roles',
            'related_id',
            'entry_id'
        );
    }

    /**
     * Return if the model is deletable.
     *
     * @return bool
     */
    public function isDeletable()
    {
        return $this->getSlug() !== 'admin';
    }
}
