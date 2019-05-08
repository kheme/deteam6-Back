<?php
/**
 * Frontend controller for users
 *
 * PHP version 7
 *
 * @category  Contoller
 * @package   Fleetrak
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use Hash;
use DB;

use App\Models\User;

/**
 * Main UserController Class
 *
 * @category  Contoller
 * @package   Fleetrak
 * @author    Okiemute Omuta <okiemute.omuta@concept-nova.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class UserController extends Controller
{
    /**
     * Return list of users
     * 
     * @param Request $request HTTP request
     * @param int     $user_id (Optional) Primary key of user of interest
     *
     * @return void
     */
    protected function viewUsers(Request $request, $user_id = null)
    {
        $auth_user       = auth()->user();
        $cant_view_users = userLacksPermission($auth_user, 'users.view');
        
        if ($cant_view_users) {
            return accessDenied('cannot view users');
        }

        $users = User::orderBy('users.created_at')
            ->join('roles', 'roles.id', 'users.role_id')
            ->selectRaw(
                'users.id, users.name, users.email,
                roles.id AS role_id, roles.name AS role_name'
            );

        $with_permissions = false;

        if ($request->with_permissions == 'true') {
            $with_permissions = true;
        }

        if ($with_permissions) {
            $users = $users->with(
                [
                    'permissions' => function ($query) {
                        $query->select('permissions.id', 'permissions.name');
                    }
                ]
            );
        }

        if ($user_id) {
            $users = $users->where('users.id', $user_id)->first();
            
            if ($users) {
            } else {
                return jsonErrorResponse('User not found');
            }
        } else {
            $users = $users->get();
        }

        return jsonSuccessResponse($users);
    }

    /**
     * Return user details
     * 
     * @param Request $request HTTP request
     * @param int     $user_id Primary key of user of interest
     *
     * @return void
     */
    protected function viewUserDetails(Request $request, $user_id)
    {
        $auth_user       = auth()->user();
        $cant_view_users = userLacksPermission($auth_user, 'users.view');
        
        if ($cant_view_users) {
            return accessDenied('cannot view users');
        }

        $user = User::orderBy('name')
            ->join('roles', 'roles.id', 'users.role_id')
            ->where('users.id', $user_id)
            ->selectRaw(
                'users.id, users.name, role_id, roles.name AS role_name'
            );

        $with_permissions = false;

        if ($request->with_permissions == 'true') {
            $with_permissions = true;
        }

        if ($with_permissions) {
            $user = $user->with(
                [
                    'permissions' => function ($query) {
                        $query->select('permissions.id', 'permissions.name');
                    }
                ]
            );
        }

        $user = $user->first();
        
        if ($user) {
            $user->toArray();
        } else {
            return jsonErrorResponse('User not found');
        }
        
        return jsonSuccessResponse($user);
    }
 
    /**
     * Create a new user
     * 
     * @param Request $request HTTP request
     *
     * @return void
     */
    protected function createUser(Request $request)
    {
        $auth_user         = auth()->user();
        $cant_create_users = userLacksPermission($auth_user, 'users.create');
        
        if ($cant_create_users) {
            return accessDenied('cannot create users');
        }

        $validator = Validator::make(
            $request->all(),
            [ 
                'name'       => 'required',
                'email'      => 'required|email|unique:users,email',
                'phone'      => 'required|numeric|digits_between:10,11',
                'role_id'    => 'required|exists:roles,id',
                'password'   => 'required', 
            ]
        );
        
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            
            return jsonErrorResponse($errors);
        }

        DB::beginTransaction();

        $request->merge(
            [
                'password'          => Hash::make($request->password),
                'email_verified_at' => now()
            ]
        );

        $created_user = User::create($request->all());
        $data = clone $created_user;

        unset($data->created_at);
        unset($data->updated_at);
        unset($data->email_verified_at);

        if ($created_user) {
            DB::commit();
            return jsonSuccessResponse($data);
        }
        
        return jsonErrorResponse('Unable to create user');
    }

    /**
     * Update existing user details
     * 
     * @param Request $request HTTP request
     * @param int     $user_id (Optional) Primary key of user of interest
     *
     * @return void
     */
    protected function updateUser(Request $request, $user_id = null)
    {
        $auth_user         = auth()->user();
        $cant_update_users = userLacksPermission($auth_user, 'users.update');
        
        if ($cant_update_users) {
            return accessDenied('cannot create users');
        }

        $validator = Validator::make(
            $request->all(),
            [ 
                'name'       => 'required',
                'email'      => "required|email|unique:users,email,$user_id",
                'phone'      => 'required|numeric|digits_between:10,11',
                'role_id'    => 'required|exists:roles,id',
                'password'   => 'required', 
            ]
        );
        
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            
            return jsonErrorResponse($errors);
        }

        DB::beginTransaction();

        $request->merge(
            [
                'password' => Hash::make($request->password)
            ]
        );

        $found_user = User::where('id', $user_id)->first();
        $user_data = $request->except('_token');

        if ($found_user->update($user_data)) {
            DB::commit();
            return jsonSuccessResponse();
        }
        
        return jsonErrorResponse('Unable to update user');
    }

    /**
     * Delete a user
     * 
     * @param Request $request HTTP request
     * @param int     $user_id Primary key of user of interest
     *
     * @return void
     */
    protected function deleteUser(Request $request, $user_id = null)
    {
        $auth_user         = auth()->user();
        $cant_delete_users = userLacksPermission($auth_user, 'users.delete');
        
        if ($cant_delete_users) {
            return accessDenied('cannot delete users');
        }
        $user = User::where('id', $user_id)->first();
        
        if ($user) {
            $user->delete();
        } else {
            return jsonErrorResponse('User not found');
        }
        
        return jsonSuccessResponse();
    }
}
