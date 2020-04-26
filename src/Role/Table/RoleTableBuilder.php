<?php

namespace Anomaly\UsersModule\Role\Table;

use Anomaly\Streams\Platform\Ui\Table\TableBuilder;

/**
 * Class RoleTableBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RoleTableBuilder extends TableBuilder
{

    /**
     * The table filters.
     *
     * @var array
     */
    protected $filters = [
        'search' => [
            'fields' => [
                'name',
                'slug',
                'description',
            ],
        ],
    ];

    /**
     * The table columns.
     *
     * @var array
     */
    protected $columns = [
        'name',
        'description',
    ];

    /**
     * The table buttons.
     *
     * @var array
     */
    protected $buttons = [
        'edit',
        'abilities' => [
            'button' => 'info',
            'icon'   => 'lock',
            'href'   => 'admin/users/roles/abilities/{entry.id}',
        ],
    ];
}
