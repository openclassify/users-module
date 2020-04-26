<?php namespace Anomaly\UsersModule\Role\Permission;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class PermissionFormSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class PermissionFormSections
{

    /**
     * Handle the fields.
     *
     * @param PermissionFormBuilder $builder
     * @param AddonCollection $addons
     */
    public function handle(PermissionFormBuilder $builder, AddonCollection $addons)
    {
        $sections = [];

        $sections['streams']['title'] = 'streams::message.system';

        foreach (config('streams::permissions', []) as $group => $permissions) {
            $sections['streams']['fields'][] = 'streams::' . $group;
        }

        /* @var Addon $addon */
        foreach ($addons->withConfig('permissions') as $addon) {
            $sections[$addon->getNamespace()]['title']       = $addon->getName();
            $sections[$addon->getNamespace()]['description'] = $addon->getDescription();

            foreach (config($addon->getNamespace('permissions'), []) as $group => $permissions) {
                $sections[$addon->getNamespace()]['fields'][] = str_replace('.', '_', $addon->getNamespace($group));
            }
        }

        /**
         * Allow custom configured permissions
         * to be hooked in to the form as well.
         */
        if ($permissions = config('anomaly.module.users::config.permissions')) {
            foreach ($permissions as $namespace => $group) {
                if ($title = array_get($group, 'title')) {
                    $sections[$namespace]['title'] = $title;
                }

                if ($description = array_get($group, 'description')) {
                    $sections[$namespace]['description'] = $description;
                }

                $sections[$namespace]['fields'] = array_get($sections[$namespace], 'fields', []);

                $sections[$namespace]['fields'] += array_map(
                    function ($permission) use ($namespace) {
                        return str_replace('.', '_', $namespace . '::' . $permission);
                    },
                    array_keys(array_get($group, 'permissions'))
                );
            }
        }

        $builder->setSections($sections);
    }
}
