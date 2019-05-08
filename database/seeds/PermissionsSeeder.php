<?php

use Illuminate\Database\Seeder;

use App\Models\Permission;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            'users.create',
            'users.view',
            'users.update',
            'users.delete'
        ];

        foreach ($permissions as $permission) {
            DB::table('permissions')
                ->insert(
                    [
                        'name'       => $permission,
                        'created_at' => now(),
                        'updated_at' => now()
                    ]
                );
        }

        return "Permissions Table Seeded!";
    }
}
