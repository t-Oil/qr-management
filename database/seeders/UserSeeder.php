<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;
use Carbon\Carbon;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'username'      =>  'admin',
            'email'     =>  'admin@admin.com',
            'password'  =>  bcrypt('Admin'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => 1
        ]);

        User::create([
            'username'      =>  'user',
            'email'     =>  'user@user.com',
            'password'  =>  bcrypt('User'),
            'email_verified_at' => Carbon::now(),
            'is_admin' => 0
        ]);

    }
}
