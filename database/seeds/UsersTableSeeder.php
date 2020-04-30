<?php

use App\Category;
use App\Team;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'firstname'            => 'Admin',
            'lastname'             => 'Admin',
            'email'                => 'admin@material.com',
            'status'                 => 'active',
            'password'             => Hash::make('secret'),
            'created_at'           => now(),
            'updated_at'           => now(),
            'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        DB::table('users')->insert([
            'firstname'            => 'Toby',
            'lastname'             => 'Powell-Blyth',
            'email'                => 'toby@powellblyth.com',
            'status'                 => 'active',
            'password'             => Hash::make('moomoomoo'),
            'created_at'           => now(),
            'updated_at'           => now(),
            'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
        DB::table('users')->insert([
            'firstname'            => 'ES Toby',
            'lastname'             => 'Powell-Blyth',
            'email'                => 'toby.powell-blyth@elasticstage.com',
            'status'                 => 'active',
            'password'             => Hash::make('MooMooMoo1'),
            'created_at'           => now(),
            'updated_at'           => now(),
            'auth_token'           => md5(random_int(PHP_INT_MIN, PHP_INT_MAX)),
            'password_reset_token' => ''
        ]);
    }
}
