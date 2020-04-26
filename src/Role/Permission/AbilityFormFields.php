<?php

namespace Anomaly\UsersModule\Role\Ability;

use Anomaly\Streams\Platform\Addon\AddonCollection;
use Anomaly\UsersModule\Role\Contract\RoleInterface;
use Illuminate\Translation\Translator;

/**
 * Class AbilityFormFields
 *
 * @link   http://pyrocms.com/
 * @author PyroCMS, Inc. <support@pyrocms.com>
 * @author Ryan Thompson <ryan@pyrocms.com>
 */
class AbilityFormFields
{

    /**
     * Handle the fields.
     *
     * @param AbilityFormBuilder $builder
     * @param AddonCollection $addons
     */
    public function handle(
        AbilityFormBuilder $builder,
        AddonCollection $addons
    ) {
        /* @var RoleInterface $role */
        $role = $builder->getEntry();

        $fields = [];

        $namespaces = array_merge(['streams'], $addons->withConfig('abilities')->namespaces());

        /*
         * Gather all the addons with a
         * abilities configuration file.
         *
         * @var Addon $addon
         */
        foreach ($namespaces as $namespace) {
            foreach (config($namespace . '::abilities', []) as $group => $abilities) {

                /*
                 * Determine the general
                 * form UI components.
                 */
                $label = $namespace . '::ability.' . $group . '.name';

                if (!trans()->has($warning = $namespace . '::ability.' . $group . '.warning')) {
                    $warning = null;
                }

                if (!trans()->has(
                    $instructions = $namespace . '::ability.' . $group . '.instructions'
                )) {
                    $instructions = null;
                }

                /*
                 * Gather the available
                 * abilities for the group.
                 */
                $available = array_combine(
                    array_map(
                        function ($ability) use ($namespace, $group) {
                            return $namespace . '::' . $group . '.' . $ability;
                        },
                        $abilities
                    ),
                    array_map(
                        function ($ability) use ($namespace, $group) {
                            return $namespace . '::ability.' . $group . '.option.' . $ability;
                        },
                        $abilities
                    )
                );

                /*
                 * Build the checkboxes field
                 * type to handle the UI.
                 */
                $fields[str_replace('.', '_', $namespace . '::' . $group)] = [
                    'label'        => $label,
                    'warning'      => $warning,
                    'instructions' => $instructions,
                    'type'         => 'anomaly.field_type.checkboxes',
                    'value'        => $role->getAbilities(),
                    'config'       => [
                        'options' => $available,
                    ],
                ];
            }
        }

        /**
         * Allow custom configured abilities
         * to be hooked in to the form as well.
         */
        if ($abilities = config('anomaly.module.users::config.abilities')) {
            foreach ($abilities as $namespace => $group) {
                foreach (array_get($group, 'abilities', []) as $ability => $abilities) {
                    $fields[str_replace('.', '_', $namespace . '::' . $ability)] = [
                        'label'        => array_get($abilities, 'label'),
                        'warning'      => array_get($abilities, 'warning'),
                        'instructions' => array_get($abilities, 'instructions'),
                        'type'         => 'anomaly.field_type.checkboxes',
                        'value'        => $role->getAbilities(),
                        'config'       => [
                            'options' => array_get($abilities, 'available', []),
                        ],
                    ];
                }
            }
        }

        $builder->setFields(translate($fields));
    }
}
