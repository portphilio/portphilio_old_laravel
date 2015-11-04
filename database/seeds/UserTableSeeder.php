<?php

use Cartalyst\Sentinel\Native\Facades\Sentinel;
use Illuminate\Database\Seeder;

class UserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $creds = [
            'first_name' => 'Morgan',
            'last_name' => 'Benton',
            'username' => 'mcbenton',
            'email' => 'morgan.benton@gmail.com',
            'password' => env('TEST_PASSWORD'),
        ];
        Sentinel::registerAndActivate($creds);
    }
}
