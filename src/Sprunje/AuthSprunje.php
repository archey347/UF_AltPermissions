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

use UserFrosting\Sprinkle\AltPermissions\Database\Models\Auth;
use UserFrosting\Sprinkle\Core\Sprunje\Sprunje;

/**
 * AuthSprunje.
 *
 * Sprunje displaying the
 *
 * @author Louis Charette (https://github.com/lcharette)
 */
class AuthSprunje extends Sprunje
{
    protected $name = 'rolesAuth';

    /* Nb.: Since the language key is stored in the db, the db can't be
       used for sorting and filtering at this time */
    protected $sortable = [
        'user',
        'role',
    ];
    protected $filterable = [
        'user',
        'role',
    ];

    /*
     * @var Seeker. The seeker we will be looking for
     */
    protected $seeker = '';

    /*
     * @var where The attribute we'll be doing a where on
     */
    protected $where;

    /**
     * {@inheritdoc}
     */
    public function __construct($classMapper, $options, $seeker = '', $where = [])
    {
        $this->seeker = $seeker;
        $this->where = $where;

        // Run parent method
        parent::__construct($classMapper, $options);
    }

    /**
     * {@inheritdoc}
     */
    protected function baseQuery()
    {
        // Get the base altAuth Model from classmapper. Keep it for later
        $baseModel = $this->classMapper->createInstance('altAuth');

        // Get the base query
        $query = $baseModel                             // Get Auth model
                 ->forSeeker($this->seeker)             // With the seeker key
                 ->with(['user', 'role', 'seeker']);    // Eager load the relations for Handlebar

        // Apply where contraints if any
        if (!empty($this->where)) {
            $query = $query->where($this->where);
        }

        // Add the join for both user and Role so sort/fitler can work
        $query = $query->joinUser()->joinRole();

        // Select only what we really need from role and users for the filter/sort to work
        $query = $query->select(
            $baseModel->getTable().'.*',
            'users.first_name',
            'users.last_name',
            'users.user_name',
            'alt_roles.name'
        );

        return $query;
    }

    /**
     * {@inheritdoc}
     */
    protected function applyTransformations($collection)
    {
        $collection = $collection->map(function ($item, $key) {

            // Add routes
            $item->uri = [
                'delete' => $item->getRoute('api.auth.delete'),
                'edit'   => $item->getRoute('modal.auth.edit'),
            ];
        });

        return $collection;
    }

    /**
     * Filter LIKE the user info.
     *
     * @param Builder $query
     * @param mixed   $value
     *
     * @return Builder
     */
    protected function filterUser($query, $value)
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);

        return $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query = $query->orLike('users.first_name', $value)
                                ->orLike('users.last_name', $value)
                                ->orLike('users.user_name', $value);
            }

            return $query;
        });
    }

    protected function filterRole($query, $value)
    {
        // Split value on separator for OR queries
        $values = explode($this->orSeparator, $value);

        return $query->where(function ($query) use ($values) {
            foreach ($values as $value) {
                $query = $query->orLike('alt_roles.name', $value);
            }

            return $query;
        });
    }

    /**
     * Sort based on user last name.
     *
     * @param Builder $query
     * @param string  $direction
     *
     * @return Builder
     */
    protected function sortUser($query, $direction)
    {
        return $query->orderBy('users.first_name', $direction);
    }

    protected function sortRole($query, $direction)
    {
        return $query->orderBy('alt_roles.name', $direction);
    }
}
