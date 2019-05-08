<?php
/**
 * Policy for the Role model
 *
 * PHP version 7
 *
 * @category  Policy
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
namespace App\Policies;

use Illuminate\Auth\Access\HandlesAuthorization;

use App\Models\Role;
use App\Models\Permission;

/**
 * Main RolePolicy Class
 *
 * @category  Policy
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class RolePolicy
{
    use HandlesAuthorization;

    /**
     * Determine if a user can create roles
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function create($auth_user)
    {
        $can_create_roles = userHasPermission($auth_user, 'roles', 'create');

        return $can_create_roles;
    }

    /**
     * Determine if a user can list roles
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function view($auth_user)
    {
        $can_view_roles = userHasPermission($auth_user, 'roles', 'view');

        return $can_view_roles;
    }

    /**
     * Determine if a user can update roles
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function update($auth_user)
    {
        $can_update_roles = userHasPermission($auth_user, 'roles', 'update');

        return $can_update_roles;
    }
    
    /**
     * Determine if a user can delete roles
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function delete($auth_user)
    {
        $can_delete_roles = userHasPermission($auth_user, 'roles', 'delete');

        return $can_delete_roles;
    }
}
