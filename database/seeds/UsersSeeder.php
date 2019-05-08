<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $password = Hash::make('omuta.okiemute@gmail.com');

        DB::table('users')
            ->insert(
                [
                    'name'              => 'Kheme',
                    'email'             => 'omuta.okiemute@gmail.com',
                    'role_id'           => 1,
                    'password'          => $password,
                    'email_verified_at' => now(),
                    'created_at'        => now(),
                    'updated_at'        => now()
                ]
            );

        return "Users Table Seeded!";
    }
}
