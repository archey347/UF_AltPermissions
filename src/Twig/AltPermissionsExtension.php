<?php
/**
 * UserFrosting (http://www.userfrosting.com)
 *
 * @link      https://github.com/userfrosting/UserFrosting
 * @license   https://github.com/userfrosting/UserFrosting/blob/master/licenses/UserFrosting.md (MIT License)
 */
namespace UserFrosting\Sprinkle\AltPermissions\Twig;

use Interop\Container\ContainerInterface;
use UserFrosting\Sprinkle\Spanner\Database\Models\Club;
use Twig\Extension\GlobalsInterface;

/**
 * Extends Twig functionality for the AltPermissions sprinkle.
 *
 * @author Archey Barrell
 */
class AltPermissionsExtension extends \Twig_Extension implements \Twig_Extension_GlobalsInterface 
{

    /**
     * @var ContainerInterface The global container object, which holds all your services.
     */
    protected $services;

    /**
     * Constructor.
     *
     * @param ContainerInterface $services The global container object, which holds all your services.
     */
    public function __construct(ContainerInterface $services)
    {
        $this->services = $services;
    }

    /**
     * Get the name of this extension.
     *
     * @return string
     */
    public function getName()
    {
        return 'userfrosting/AltPermissions';
    }

    /**
     * Adds Twig functions 'checkSeekerAccess'
     *
     * @return array[\Twig_SimpleFunction]
     */
    public function getFunctions()
    {
        return array(
            // Add Twig function for checking permissions for a seeker
            new \Twig_SimpleFunction('checkSeekerAccess', function ($slug, $seeker_id = "") {
                $acl =  $this->services->acl; 
                return $acl->hasPermission($this->services->currentUser, $slug, $seeker_id);     
            }),
            new \Twig_SimpleFunction('getSeekersForUser', function ($seeker_type) {
                $acl =  $this->services->acl; 
                return $acl->getSeekersForUser($this->services->currentUser, $seeker_type)->pluck('id');     
            })
        );
    }   

    public function getGlobals() {
        return [];
    }
}
