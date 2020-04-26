<?php namespace Anomaly\UsersModule\Role;

use Anomaly\Streams\Platform\Entry\EntryCollection;
use Anomaly\Streams\Platform\Entry\EntryRepository;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;

/**
 * Class RoleRepositoryInterface
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RoleRepository extends EntryRepository implements RoleRepositoryInterface
{

    /**
     * The role model.
     *
     * @var RoleModel
     */
    protected $model;

    /**
     * Create a new RoleRepositoryInterface instance.
     *
     * @param RoleModel $model
     */
    public function __construct(RoleModel $model)
    {
        $this->model = $model;
    }

    /**
     * Return all but the admin role.
     *
     * @return RoleCollection
     */
    public function allButAdmin()
    {
        return $this->model->where('slug', '!=', 'admin')->get();
    }

    /**
     * Return all but the admin and guest role.
     *
     * @return RoleCollection
     */
    public function allButAdminAndGuest()
    {
        return $this->model
            ->where('slug', '!=', 'admin')
            ->where('slug', '!=', 'guest')
            ->get();
    }

    /**
     * Find a role by it's slug.
     *
     * @param $slug
     * @return null|RoleInterface
     */
    public function findBySlug($slug)
    {
        return $this->model->where('slug', $slug)->first();
    }

    /**
     * Find a role by a ability key.
     *
     * @param $ability
     * @return null|EntryCollection
     */
    public function findByAbility($ability)
    {
        $query = $this->model->newQuery();

        foreach ((array)$ability as $key) {
            $query->where('abilities', 'LIKE', '%"' . str_replace('*', '%', $key) . '"%');
        }

        return $query->get();
    }

    /**
     * Update abilities for a role.
     *
     * @param  RoleInterface $role
     * @param  array $abilities
     * @return RoleInterface
     */
    public function updateAbilities(RoleInterface $role, array $abilities)
    {
        $role->abilities = $abilities;

        $role->save();

        return $role;
    }
}
