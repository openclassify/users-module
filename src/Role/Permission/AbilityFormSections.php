<?php namespace Anomaly\UsersModule\Role\Ability;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Addon\AddonCollection;

/**
 * Class AbilityFormSections
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AbilityFormSections
{

    /**
     * Handle the fields.
     *
     * @param AbilityFormBuilder $builder
     * @param AddonCollection $addons
     */
    public function handle(AbilityFormBuilder $builder, AddonCollection $addons)
    {
        $sections = [];

        $sections['streams']['title'] = 'streams::message.system';

        foreach (config('streams::abilities', []) as $group => $abilities) {
            $sections['streams']['fields'][] = 'streams::' . $group;
        }

        /* @var Addon $addon */
        foreach ($addons->withConfig('abilities') as $addon) {
            $sections[$addon->getNamespace()]['title']       = $addon->getName();
            $sections[$addon->getNamespace()]['description'] = $addon->getDescription();

            foreach (config($addon->getNamespace('abilities'), []) as $group => $abilities) {
                $sections[$addon->getNamespace()]['fields'][] = str_replace('.', '_', $addon->getNamespace($group));
            }
        }

        /**
         * Allow custom configured abilities
         * to be hooked in to the form as well.
         */
        if ($abilities = config('anomaly.module.users::config.abilities')) {
            foreach ($abilities as $namespace => $group) {
                if ($title = array_get($group, 'title')) {
                    $sections[$namespace]['title'] = $title;
                }

                if ($description = array_get($group, 'description')) {
                    $sections[$namespace]['description'] = $description;
                }

                $sections[$namespace]['fields'] = array_get($sections[$namespace], 'fields', []);

                $sections[$namespace]['fields'] += array_map(
                    function ($ability) use ($namespace) {
                        return str_replace('.', '_', $namespace . '::' . $ability);
                    },
                    array_keys(array_get($group, 'abilities'))
                );
            }
        }

        $builder->setSections($sections);
    }
}
