<?php

namespace Anomaly\UsersModule\Http\Controller\Admin;

use Anomaly\Streams\Platform\Http\Controller\AdminController;
use Anomaly\UsersModule\Role\Form\RoleFormBuilder;
use Anomaly\UsersModule\Role\Ability\AbilityFormBuilder;
use Anomaly\UsersModule\Role\Table\RoleAbilityTableBuilder;
use Anomaly\UsersModule\Role\Table\RoleTableBuilder;

/**
 * Class RolesController
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class RolesController extends AdminController
{

    /**
     * Return an index of existing roles.
     *
     * @param  RoleTableBuilder $form
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function index(RoleTableBuilder $form)
    {
        return $form->render();
    }

    /**
     * Return a form for a new role.
     *
     * @param  RoleFormBuilder $form
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function create(RoleFormBuilder $form)
    {
        return $form->render();
    }

    /**
     * Return a form for an existing role.
     *
     * @param  RoleFormBuilder                                                  $form
     * @param                                                                   $id
     * @return \Illuminate\View\View|\Symfony\Component\HttpFoundation\Response
     */
    public function edit(RoleFormBuilder $form, $id)
    {
        return $form->render($id);
    }

    /**
     * Return the form for editing abilities.
     *
     * @param  AbilityFormBuilder                      $form
     * @param                                             $id
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function abilities(AbilityFormBuilder $form, $id)
    {
        return $form->render($id);
    }
}
