<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2013-2016 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */

use League\FactoryMuffin\Faker\Facade as Faker;


/**
 * General factory for the User Model
 */
$fm->define('UserFrosting\Sprinkle\AltPermissions\Database\Models\User')->setDefinitions([
    'user_name' => Faker::firstNameMale(),
    'first_name' => Faker::firstNameMale(),
    'last_name' => Faker::firstNameMale(),
    'email'    => Faker::email(),
    'locale' => 'en_US',
    'flag_verified' => 1,
    'flag_enabled' => 1,
    'password' => Faker::password()
]);