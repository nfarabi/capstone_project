<?php

use App\User;
use Carbon\Carbon;
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
        // create user
        $superAdmin = User::create([
            'name' => 'Jhon',
            'last_name' => 'Doe',
            'email' => 'admin@admin.com',
            'password' => 'password',
            'activated_at' => Carbon::now(),
            'email_verified_at' => Carbon::now()
        ]);

        // Attach role
        $superAdmin->assignRole(['super-admin']);
    }
}
