<?php

namespace Anomaly\UsersModule\Role\Ability;

use Anomaly\Streams\Platform\Addon\Addon;
use Anomaly\Streams\Platform\Message\MessageManager;
use Anomaly\Streams\Platform\Ui\Breadcrumb\BreadcrumbCollection;
use Anomaly\Streams\Platform\Ui\Form\FormBuilder;
use Anomaly\UsersModule\Role\Contract\RoleRepositoryInterface;
use Illuminate\Routing\Redirector;

/**
 * Class AbilityFormBuilder
 *
 * @link          http://pyrocms.com/
 * @author        PyroCMS, Inc. <support@pyrocms.com>
 * @author        Ryan Thompson <ryan@pyrocms.com>
 */
class AbilityFormBuilder extends FormBuilder
{

    /**
     * The addon to modify
     * abilities for.
     *
     * @var null|Addon
     */
    protected $addon = null;

    /**
     * No model needed.
     *
     * @var bool
     */
    protected $model = false;

    /**
     * Disable saving.
     *
     * @var bool
     */
    protected $save = false;

    /**
     * The form actions.
     *
     * @var array
     */
    protected $actions = [
        'save' => [
            'href' => 'admin/users/abilities/{request.route.parameters.id}',
        ],
    ];

    /**
     * The form options.
     *
     * @var array
     */
    protected $options = [
        'breadcrumb' => false,
        'ability' => 'anomaly.module.users::users.abilities',
    ];

    /**
     * Fired when builder is ready to build.
     *
     * @param  RoleRepositoryInterface $roles
     * @param  BreadcrumbCollection    $breadcrumbs
     * @param  MessageManager              $messages
     * @param  Redirector              $redirect
     * @return \Illuminate\Http\RedirectResponse
     */
    public function onReady(
        RoleRepositoryInterface $roles,
        BreadcrumbCollection $breadcrumbs,
        MessageManager $messages,
        Redirector $redirect
    ) {
        $this->setEntry($role = $roles->find($this->getEntry()));

        if ($role->getSlug() === 'admin') {
            $messages->warning('anomaly.module.users::warning.modify_admin_abilities');

            $this->setFormResponse($redirect->to('admin/users/roles'));

            return;
        }

        $breadcrumbs->add($role->getName(), 'admin/users/roles/edit/' . $role->getKey());
        $breadcrumbs->add(
            'anomaly.module.users::breadcrumb.abilities',
            'admin/users/roles/abilities/' . $role->getKey()
        );
    }

    /**
     * If nothing is posted then
     * the role gets no abilities.
     *
     * @param RoleRepositoryInterface $roles
     */
    public function onPost(RoleRepositoryInterface $roles)
    {
        if (!$this->hasPostData() && $entry = $this->getEntry()) {
            $roles->save($entry->setAttribute('abilities', []));
        }
    }

    /**
     * Get the addon.
     *
     * @return null|Addon
     */
    public function getAddon()
    {
        return $this->addon;
    }

    /**
     * Set the addon.
     *
     * @param  Addon $addon
     * @return $this
     */
    public function setAddon(Addon $addon)
    {
        $this->addon = $addon;

        return $this;
    }
}
