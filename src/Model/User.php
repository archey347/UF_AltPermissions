<?php
 /**
 * UF AltPermissions
 *
 * @link      https://github.com/lcharette/UF-AltPermissions
 * @copyright Copyright (c) 2016 Louis Charette
 * @license   https://github.com/lcharette/UF-AltPermissions/blob/master/licenses/UserFrosting.md (MIT License)
 */

namespace UserFrosting\Sprinkle\AltPermissions\Model;

use UserFrosting\Sprinkle\Account\Model\User as CoreUser;

/**
 * AltPermissionUser
 *
 * Trait to add AltPermission Sprinkle methods to the core User Model
 * @author Louis Charette (https://github.com/lcharette)
 */
class User extends CoreUser
{
    //!TODO : Check if this is necessary
    public function seeker($seeker)
    {
        $seekerClass = static::$ci->checkAuthSeeker->getSeekerModel($seeker);
        return $this->morphedByMany($seekerClass, 'seeker', 'alt_role_users')->withPivot('role_id');
    }

    public function auth($seeker = "")
    {
        if ($seeker != "")
        {
            $seekerClass = static::$ci->checkAuthSeeker->getSeekerModel($seeker);
            return $this->hasMany('UserFrosting\Sprinkle\AltPermissions\Model\Auth')->where('seeker_type', $seekerClass)->get();
        }
        else
        {
            return $this->hasMany('UserFrosting\Sprinkle\AltPermissions\Model\Auth');
        }
    }

    public function roleForSeeker($seeker, $seeker_id)
    {
        return $this->auth($seeker)->where('seeker_id', $seeker_id)->first()->role;
    }
}
