<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        User::create(['last_name'=>'Альпенов', 'first_name' => 'Танат', 'middle_name' => 'Маратович', 'email' => 'researcher2286@gmail.com', 'password' => Hash::make('123')]);
    }
}