# AltPermission Sprinkle for [UserFrosting 4](https://www.userfrosting.com)

[![Build Status](https://travis-ci.org/lcharette/UF_AltPermissions.svg?branch=master)](https://travis-ci.org/lcharette/UF_AltPermissions) [![StyleCI](https://github.styleci.io/repos/86100743/shield?branch=master)](https://github.styleci.io/repos/86100743) [![UserFrosting Version](https://img.shields.io/badge/UserFrosting->=%204.2-brightgreen.svg)](https://github.com/userfrosting/UserFrosting) [![Donate](https://img.shields.io/badge/Donate-Buy%20Me%20a%20Coffee-brightgreen.svg)](https://ko-fi.com/A7052ICP)

Alternate/complementary permission system for [UserFrosting 4](https://www.userfrosting.com)

> This sprinkle is still a work in progress and not ready yet for production use. No official release has been made yet. Fell free to test it and contribute, or use it as a reference.

# Help and Contributing

If you need help using this sprinkle or found any bug, feels free to open an issue or submit a pull request. You can also find me on the [UserFrosting Chat](https://chat.userfrosting.com/) most of the time for direct support.

# Installation

Edit UserFrosting `app/sprinkles/sprinkles.json` file and add the following to the `require` list :
```
"lcharette/UF_AltPermissions": "dev-master"
```

Run `composer update` then `composer run-script bake` to install the sprinkle.

# Usage

## Permission Slug Inheritance

If you have a collection of permisisons of actions that are available on a page, you can group these together using dot-delimiter.

For example, if you have a page that allows you to manage a team, you might have the permissions `team.view`, `team.edit`, `team.delete`. Then, to test access to the page, you can do `hasPermission('team')` rather than having to test for each permission.
`

# Seeker Parents/Children

This allows for a permission and a role that have different seekers to be associated with each other. 

For example, you may have a scenario where you have multiple organisations, and there are multiple teams inside each organisation. You may need to give some people access to all of the teams in an individual organisation, and then others just access to individual teams. You could do this by having a `team.view` permission that has a seeker type, `team`, and then a role called `Organisation Manager` that has seeker type `organisation`. Then, you would have to mofify the organisation and team models to tell the access control layer that there is a parent/child relationship.

```php
class Organisation extends Model implements IPermissionParent
{
    protected $table = 'organisations';

    protected function getChildren($seekerType) {
        if($seekerType == 'team') {
            return $this->teams();
        }
    }

    protected function teams() {
        return $this->hasMany('...Models\Team');
    }

    ...
}

class Team extends Model implements IPermissionChild
{
    $table_name = 'teams';

    protected function getChildren($seekerType) {
        if($seekerType == 'team') {
            return $this->teams();
        }
    }

    protected function teams() {
        return $this->hasMany('...Models\Team');
    }

    ...
}
```
# Licence

By [Louis Charette](https://github.com/lcharette). Copyright (c) 2017, free to use in personal and commercial software as per the MIT license.
