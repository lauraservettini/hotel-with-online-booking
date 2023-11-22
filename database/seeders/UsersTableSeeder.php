<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table("users")->insert(
            //Admin
            [
                "name" => "Admin",
                "email" => "admin@gmail.com",
                "password" => Hash::make("Admin"),
                "role" => "Admin",
                "status" => "active"
            ]
        );

        DB::table("users")->insert(
            //User
            [
                "name" => "User",
                "email" => "user@gmail.com",
                "password" => Hash::make("User"),
                "role" => "user",
                "status" => "active"
            ]
        );
    }
}
