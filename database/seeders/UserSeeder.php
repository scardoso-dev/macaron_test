<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        User::truncate();
        $faker = \Faker\Factory::create();
        $password = Hash::make("test");

        $userDefault = User::create([
            'name' => 'test TEST',
            'email' => 'test@test.fr',
            'password' => $password,
            'email_verified_at' => now()
        ]);       
    }
}
