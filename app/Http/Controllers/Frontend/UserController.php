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
        if (auth()->user()->cannot('users.view')) {
            return accessDenied('cannot view users');
        }

        $users = User::orderBy('users.created_at')
            ->join('roles', 'roles.id', 'users.role_id')
            ->selectRaw(
                'users.id, users.name,
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
            $users = $users->where('users.id', $user_id);
            
            if ($users) {
                $users = $users->first();

                dd($users->role());
            } else {
                return jsonErrorResponse('User not found');
            }
        } else {
            $users = $users->get();
        }

        return jsonSuccessResponse($users);
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
        if (auth()->user()->cannot('users.create')) {
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
     * Return user details
     * 
     * @param Request $request HTTP request
     * @param int     $user_id Primary key of user of interest
     *
     * @return void
     */
    protected function viewUserDetails(Request $request, $user_id)
    {
        if (auth()->user()->cannot('users.view')) {
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
}
