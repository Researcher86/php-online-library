<?php

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        factory(User::class)->create(['email' => 'test@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test2@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test3@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test4@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test5@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test6@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test7@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test8@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test9@test.com', 'password' => Hash::make('123')]);
        factory(User::class)->create(['email' => 'test10@test.com', 'password' => Hash::make('123')]);
    }
}