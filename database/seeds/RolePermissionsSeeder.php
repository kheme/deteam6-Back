<?php

use Illuminate\Database\Seeder;

use App\Models\Permission;

class RolePermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = Permission::select('id')->get();

        foreach ($permissions as $permission) {
            DB::table('role_permissions')
                ->insert(
                    [
                        'role_id'       => 1,
                        'permission_id' => $permission->id,
                        'created_at'    => now(),
                        'updated_at'    => now()
                    ]
                );
        }

        return "Roles Table Seeded!";
    }
}
