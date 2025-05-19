<?php

namespace Database\Seeders;

use App\Models\Admin;
use Dom\Attr;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class test extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
       
        Admin::create(
            [ // يُستخدم لتجنب تكرار السطر إذا كان موجود
            
                'name' => 'Super Admin',
                'password' => Hash::make('password123'), // غير كلمة السر كما تريد
                'type' => 'supersdmin', // أو 'super_admin' حسب النظام عندك
            
        ]);
    }
}
