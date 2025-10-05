<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $users = [
            [
                'id'             => 1000,
                'email'          => 'admin@admin.com',
                'role'           => 'Admin',
                'first_name'     => 'Admin',
                'last_name'      => '',
                'phone'          => '123456798',
                'birth'          => '1980-01-01',
                'nationality'    => 'Rus',

                'zip'            => NULL,
                'country'        => NULL,
                'city'           => NULL,
                'address1'       => NULL,
                'address2'       => NULL,
                'house'          => NULL,

                'investment'     => 0,
                'notes'          => NULL,
                'attention'      => 0,
                'approved'       => 0,
                'test'           => 'None',
                'investor_type'  => 'self',
                'password'       => Hash::make('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),

            ],
            [
                'id'             => 1001,
                'email'          => 'user@admin.com',
                'role'           => 'User',
                'first_name'     => 'User',
                'last_name'      => '',
                'phone'          => '123456798',
                'birth'          => '2010-01-01',
                'nationality'    => 'Rus',

                'zip'            => '456789',
                'country'        => 'Britannia',
                'city'           => 'Vesper',
                'address1'       => 'Holiday inn',
                'address2'       => 'Mage guild',
                'house'          => 'green',

                'investment'     => 100,
                'notes'          => 'notes',
                'attention'      => 0,
                'approved'       => 0,
                'test'           => 'None',
                'investor_type'  => 'self',
                'password'       => Hash::make('password'),
                'remember_token' => Str::random(60),
                'email_verified_at' => now(),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ];
        DB::table('users')->insert($users);
    }
}
