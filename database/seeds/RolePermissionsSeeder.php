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
        $permissions = [
            '.ignore',
            'users.create',
            'users.view',
            'users.update',
            'users.delete'
        ];

        foreach ($permissions as $index => $permission) {
            if ($index) {
                DB::table('role_permissions')
                    ->insert(
                        [
                            'role_id'       => 1,
                            'permission_id' => $index,
                            'created_at'    => now(),
                            'updated_at'    => now()
                        ]
                    );
            }
        }

        return "Roles Table Seeded!";
    }
}
