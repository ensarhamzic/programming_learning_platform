<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

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
            "JMBG" => "0000000000000",
            "role_id" => 1,
            "name" => "Admin",
            "surname" => "Admin",
            'username' => 'admin',
            'email' => "admin@admin.com",
            'gender' => 'M',
            'birth_place' => 'Admin',
            'birth_country' => 'Admin',
            'birth_date' => '2023-01-01',
            'mobile_number' => '000000000',
            'password' => Hash::make("admin"),
            'approved' => true
        ]);
    }
}
