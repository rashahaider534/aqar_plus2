<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AddUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'huda',
            'email' => 'huda@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'user',
            'code' => 12345,
            'in_code' => 1,
            'consent' => 'not_requested',
            'balance' => 100000,
            'profile_photo' => 'http://127.0.0.1:8000/storage/profile_photos/default_profile_photo.png'
        ]);
        User::create([
            'name' => 'rasha',
            'email' => 'rasha@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'user',
            'code' => 12345,
            'in_code' => 1,
            'consent' => 'not_requested',
            'balance' => 100000,
            'profile_photo' => 'http://127.0.0.1:8000/storage/profile_photos/default_profile_photo.png'
        ]);
        User::create([
            'name' => 'touka',
            'email' => 'touka@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'user',
            'code' => 12345,
            'in_code' => 1,
            'consent' => 'not_requested',
            'balance' => 100000,
            'profile_photo' => 'http://127.0.0.1:8000/storage/profile_photos/default_profile_photo.png'
        ]);
        User::create([
            'name' => 'hajar',
            'email' => 'hajar@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'seller',
            'code' => 12345,
            'in_code' => 1,
            'consent' => 'requested',
            'balance' => 100000,
            'profile_photo' => 'http://127.0.0.1:8000/storage/profile_photos/default_profile_photo.png',
            'name_admin' => 'Admin1'
        ]);
        User::create([
            'name' => 'rama',
            'email' => 'rama@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'seller',
            'code' => 12345,
            'in_code' => 1,
            'consent' => 'requested',
            'balance' => 100000,
            'profile_photo' => 'http://127.0.0.1:8000/storage/profile_photos/default_profile_photo.png',
            'name_admin' => 'Admin1'
        ]);
        User::create([
            'name' => 'sara',
            'email' => 'sara@gmail.com',
            'password' => Hash::make('12345678'),
            'type' => 'seller',
            'code' => 12345,
            'in_code' => 1,
            'consent' => 'requested',
            'balance' => 100000,
            'profile_photo' => 'http://127.0.0.1:8000/storage/profile_photos/default_profile_photo.png',
            'name_admin' => 'Admin1'
        ]);
    }
}