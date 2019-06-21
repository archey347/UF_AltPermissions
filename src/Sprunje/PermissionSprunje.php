<?php

/*
 * UF AltPermissions
 *
 * @link https://github.com/lcharette/UF-AltPermissions
 *
 * @copyright Copyright (c) 2016 Louis Charette
 * @license https://github.com/lcharette/UF-AltPermissions/blob/master/licenses/UserFrosting.md (MIT License)
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
class PermissionSprunje extends Sprunje
{
    protected $name = 'permissions';

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
    public function __construct($classMapper, $options, $role)
    {
        $this->role = $role;
        parent::__construct($classMapper, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function baseQuery()
    {
        return $this->classMapper->createInstance('altPermission')->forRole($this->role);
    }
}
