<?php

/*
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @copyright Copyright (c) 2019 Alexander Weissman
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/LICENSE.md (MIT License)
 */

namespace UserFrosting\Sprinkle\AltPermissions;

 use Illuminate\Database\Eloquent\Collection;

 interface IPermissionParent
 {
     /**
      * Gets a collection of records based on the given seeker name
      *
      * @param string $seekerName;
      *
      * @return Collection The collection of record(s) that are children to this parent
      * */
     public function getChildren(String $seekerType);
 }
