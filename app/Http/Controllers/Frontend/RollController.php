<?php
/**
 * Frontend controller for roles
 *
 * PHP version 7
 *
 * @category  Contoller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Validator;
use DB;

use App\Models\Role;
use App\Models\RolePermission;

/**
 * Main RollController Class
 *
 * @category  Contoller
 * @package   DigitalExplorers
 * @author    Okiemute Omuta <omuta.okiemute@gmail.com>
 * @copyright 2019 Okiemute Omuta. All rights reserved.
 * @license   Unauthorized copying of this file, via any medium is highly prohibited.
 * @link      https://twitter.com/kheme
 */
class RollController extends Controller
{
    /**
     * Return list of roles
     * 
     * @param Request $request HTTP request
     * @param int     $role_id (Optional) Primary key of role of interest
     *
     * @return void
     */
    protected function viewRoles(Request $request, $role_id = null)
    {
        $auth_user = auth()->user();
        
        if ($auth_user->cannot('roles.view')) {
            return accessDenied('cannot list roles');
        }

        $roles = Role::orderBy('roles.created_at')
            ->with('permissions')
            ->selectRaw(
                'roles.id, roles.name'
            )
            ->with(
                [
                    'permissions' => function ($query) {
                        $query->select('permissions.id', 'permissions.name');
                    }
                ]
            );

        if ($role_id) {
            $roles = $roles->where('roles.id', $role_id);
            
            if ($roles) {
                $roles = $roles->first();
            } else {
                return jsonErrorResponse('Role not found');
            }
        } else {
            $roles = $roles->get();
        }

        return jsonSuccessResponse($roles);
    }
 
    /**
     * Create a new user
     * 
     * @param Request $request HTTP request
     *
     * @return void
     */
    protected function createRole(Request $request)
    {
        if (auth()->user()->cannot('roles.create')) {
            return accessDenied('cannot create roles');
        }

        $validator = Validator::make(
            $request->all(),
            [ 
                'name'        => 'required|unique:roles,name',
                'permissions' => 'required|string',
            ]
        );
        
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            
            return jsonErrorResponse($errors);
        }

        DB::beginTransaction();

        $created_role = Role::create(
            [
                'name'       => $request->name,
                'account_id' => $request->account_id
            ]
        );

        if ($created_role) {
            $this->_createRolePermissions($created_role->id, $request->permissions);

            $data = Role::where('id', $created_role->id)
                ->with(
                    [
                        'permissions' => function ($query) {
                            $query->select('permissions.id', 'permissions.name');
                        }
                    ]
                )
                ->selectRaw(
                    'roles.id, roles.name'
                )
                ->first();

            DB::commit();
            
            return jsonSuccessResponse($data);
        }
        
        DB::rollback();
        return jsonErrorResponse('Unable to create role');
    }

    /**
     * Return list of roles
     * 
     * @param int $role_id Primary key of role of interest
     *
     * @return void
     */
    protected function deleteRole($role_id)
    {
        if (auth()->user()->cannot('roles.delete')) {
            return accessDenied('cannot delete roles');
        }

        $role = Role::where('id', $role_id)->first();

        if ($role) {
            DB::beginTransaction();

            $deleted_roles = $role->delete();

            if ($deleted_roles) {
                DB::commit();
                return jsonSuccessResponse();
            }
        }

        DB::rollback();
        return jsonErrorResponse('Role not found');
    }

    /**
     * Update a role
     * 
     * @param Request $request HTTP request
     * @param int     $role_id Primary key of role of interest
     *
     * @return void
     */
    protected function updateRole(Request $request, $role_id)
    {
        if (auth()->user()->cannot('roles.update')) {
            return accessDenied('cannot update roles');
        }

        $validator = Validator::make(
            $request->all(),
            [ 
                'name'        => 'required|string',
                'permissions' => 'required|string',
            ]
        );
        
        if ($validator->fails()) {
            $errors = implode(' ', $validator->errors()->all());
            
            return jsonErrorResponse($errors);
        }

        $role = Role::where('id', $role_id)->first();

        if ($role) {
            $role->update(
                [
                    'name' => ''
                ]
            );
        } else {
            return jsonErrorResponse('Role not found');
        }
    }

    /**
     * Add permissions to newly created role
     * 
     * @param int   $role_id     Primary key of role of interest
     * @param array $permissions Array of permission ID's
     *
     * @return void
     */
    private function _createRolePermissions($role_id, $permissions)
    {
        $permissions = explode(',', $permissions);
        
        foreach ($permissions as $permission_id) {
            RolePermission::create(
                [
                    'role_id'       => $role_id,
                    'permission_id' => (int) trim($permission_id)
                ]
            );
        }
    }

}
