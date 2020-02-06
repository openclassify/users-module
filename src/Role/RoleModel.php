<?php

namespace Anomaly\UsersModule\Role;

use Anomaly\UsersModule\User\UserCollection;
use Anomaly\Streams\Platform\Entry\EntryModel;
use Anomaly\Streams\Platform\Model\Traits\Streams;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Anomaly\Streams\Platform\User\Contract\RoleInterface as StreamsRole;

/**
 * Class RoleModel
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class RoleModel extends EntryModel implements RoleInterface, StreamsRole
{

    use Streams;

    /**
     * The entry table.
     *
     * @var string
     */
    protected $table = 'users_roles';

    /**
     * The cast types.
     *
     * @var array
     */
    protected $casts = [
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
        'deleted_at'  => 'datetime',
        'name'        => 'array',
        'description' => 'array',
    ];

    /**
     * The stream definition.
     *
     * @var array
     */
    protected static $stream = [
        'slug'         => 'roles',
        'title_column' => 'name',
        'trashable'    => true,
        'fields' => [
            'name'        => [
                'translatable' => true,
                'required'     => true,
                'type'         => 'anomaly.field_type.text',
            ],
            'slug'        => [
                'required' => true,
                'unique'   => true,
                'type'     => 'anomaly.field_type.slug',
                'config'   => [
                    'slugify' => 'name',
                ],
            ],
            'description' => [
                'translatable' => true,
                'type'         => 'anomaly.field_type.textarea',
            ],
            'permissions' => [
                'type' => 'anomaly.field_type.checkboxes',
            ],
        ]
    ];

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
