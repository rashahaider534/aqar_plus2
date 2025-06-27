<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddAdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       Admin::create(
            [
                'name' => 'Super Admin',
                'password' => Hash::make('password123'),
                'type' => 'superadmin',

            ]
        );
        Admin::create(
            [
                'name' => 'Admin1',
                'password' => Hash::make('12345678'),
                'type' => 'admin',

            ]
        );
        Admin::create(
            [
                'name' => 'Admin2',
                'password' => Hash::make('12345678'),
                'type' => 'admin',

            ]
        );
    }
}