<?php
/**
 * GASTON (https://github.com/lcharette/GASTON)
 *
 * @author Louis Charette
 * @link https://github.com/lcharette
 * @copyright Copyright (c) 2016 Louis Charette
 */
namespace UserFrosting\Tests\Models;

use Illuminate\Database\Capsule\Manager as Capsule;
use UserFrosting\Sprinkle\Core\Database\Models\Model;
use UserFrosting\Sprinkle\AltPermissions\Database\Models\Traits\Auth;

/**
 * Project class.
 *
 * @extends Model
 */
class Foo extends Model {

    use Auth;

    /**
     * @var string The name of the table for the current model.
     */
    protected $table = "alt_foo";

    /**
     * @var array The fields of the table for the current model.
     */
    protected $fillable = [
        "name",
        "description"
    ];

    /**
     * @var bool Enable timestamps for Users.
     */
    public $timestamps = true;
}