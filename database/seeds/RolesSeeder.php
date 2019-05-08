<?php

use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            '.ignore',
            'Super Administrator',
            'Administrator',
            'User',
            
        ];

        foreach ($roles as $index => $role) {
            if ($index) {
                DB::table('roles')
                    ->insert(
                        [
                            'name'       => $role,
                            'created_at' => now(),
                            'updated_at' => now()
                        ]
                    );
            }
        }

        return "Roles Table Seeded!";
    }
}
