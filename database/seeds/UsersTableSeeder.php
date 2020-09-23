<?php

use Illuminate\Database\Seeder;
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
        DB::table('users')->insert([
            'first_name' => 'Anand Raj',
            'last_name' => 'Raj',
            'email' => 'ram@yopmail.com',
            'email_verified_at' => now(),
            'role' => 'admin'   ,
            'password' => Hash::make('123456'),
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cms')->insert([
            'slug' => 'about_us',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cms')->insert([
            'slug' => 'privacy_policy',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cms')->insert([
            'slug' => 'terms_n_conditions',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cms')->insert([
            'slug' => 'blog',
            'created_at' => now(),
            'updated_at' => now()
        ]);
        DB::table('cms')->insert([
            'slug' => 'home_page',
            'created_at' => now(),
            'updated_at' => now()
        ]);
    }
}
