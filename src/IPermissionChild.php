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

 interface IPermissionChild
 {
     /**
      * Gets a collection of records based on the given seeker name
      *
      * @param string $seekerName;
      *
      * @return Collection The collection of record(s) that are parent to this child
      * */
     public function getParents(String $seekerName);
 }
