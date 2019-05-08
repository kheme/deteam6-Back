<?php
/**
 * Policy for the User model
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

use App\Models\User;

/**
 * Main UserPolicy Class
 *
 * @category  Policy
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine if a user can create users
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function create($auth_user)
    {
        $can_create_users = userHasPermission($auth_user, 'users', 'create');

        return $can_create_users;
    }

    /**
     * Determine if a user can list users
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function view($auth_user)
    {
        $can_view_users = userHasPermission($auth_user, 'users', 'view');

        return $can_view_users;
    }

    /**
     * Determine if a user can update users
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function update($auth_user)
    {
        $can_update_users = userHasPermission($auth_user, 'users', 'update');

        return $can_update_users;
    }
    
    /**
     * Determine if a user can delete users
     *
     * @param User $auth_user Model of authenticated user
     * 
     * @return bool
     */
    public function delete($auth_user)
    {
        $can_delete_users = userHasPermission($auth_user, 'users', 'delete');

        return $can_delete_users;
    }
}
