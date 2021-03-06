<?php

/*
 * UF AltPermissions Sprinkle
 *
 * @author    Louis Charette
 * @copyright Copyright (c) 2018 Louis Charette
 * @link      https://github.com/lcharette/UF_AltPermissions
 * @license   https://github.com/lcharette/UF_AltPermissions/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\AltPermissions\Sprunje;

use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

/**
 * RoleSprunje.
 *
 * Implements Sprunje for the roles API.
 *
 * @author Louis Charette (https://github.com/lcharette)
 */
class RoleSprunje extends Sprunje
{
    protected $name = 'roles';

    /* Nb.: Since the language key is stored in the db, the db can't be
       used for sorting and filtering at this time */
    protected $sortable = [
        'name',
        'description',
    ];
    protected $filterable = [
        'name',
        'description',
    ];

    protected $seeker = '';

    /**
     * {@inheritdoc}
     */
    public function __construct($classMapper, $options, $seeker)
    {
        $this->seeker = $seeker;
        parent::__construct($classMapper, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function baseQuery()
    {
        return $this->classMapper->createInstance('altRole')->forSeeker($this->seeker);
    }

    /**
     * {@inheritdoc}
     */
    protected function applyTransformations($collection)
    {
        $collection = $collection->map(function ($item, $key) {

            // Routes
            $item->uri = [
                'view'        => $item->getRoute('alt_uri_roles.view'),
                'delete'      => $item->getRoute('api.roles.delete'),
                'edit'        => $item->getRoute('modal.roles.edit'),
                'permissions' => $item->getRoute('modal.roles.permissions'),
            ];

            return $item;
        });

        return $collection;
    }
}
