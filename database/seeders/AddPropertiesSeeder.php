<?php

namespace Database\Seeders;

use App\Models\Property;
use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddPropertiesSeeder extends Seeder
{

    public function run(): void
    {
        Property::create([
            'province_id' => 1,
            'seller_id' => 6,
            'name' => 'فيلا',
            'type' => 'اجار',
            'month'=>rand(1, 12),
            'ownership_image' => 'http://127.0.0.1:8000/storage/ownership_doc/image.jpg',
            'month' => rand(1, 12),
            'room' => rand(1, 5),
            'name_admin' => 'Admin1',
            'final_price' => rand(1000, 7000),
            'area' => rand(50, 200),
            'description' => '1وصف للعقار رقم ',
            'status'=>'available'
        ]);
         Property::create([
            'province_id' => 4,
            'seller_id' => 5,
            'name' => 'فيلا',
            'type' => 'اجار',
            'month'=>rand(1, 12),
            'ownership_image' => 'http://127.0.0.1:8000/storage/ownership_doc/image.jpg',
            'month' => rand(1, 12),
            'room' => rand(1, 5),
            'name_admin' => 'Admin1',
            'final_price' => rand(1000, 7000),
            'area' => rand(50, 200),
            'description' => '2وصف للعقار رقم ',
            'status'=>'available'
        ]);
         Property::create([
            'province_id' => 4,
            'seller_id' => 6,
            'name' => 'شقة',
            'type' => 'بيع',
            //'month'=>rand(1, 12),
            'ownership_image' => 'http://127.0.0.1:8000/storage/ownership_doc/image.jpg',
            'month' => rand(1, 12),
            'room' => rand(1, 5),
            'name_admin' => 'Admin1',
            'final_price' => rand(100000, 500000),
            'area' => rand(50, 200),
            'description' => '3وصف للعقار رقم ',
            'status'=>'available'
        ]);
         Property::create([
            'province_id' => 1,
            'seller_id' => 4,
            'name' => 'فيلا',
            'type' => 'بيع',
            'month'=>rand(1, 12),
            'ownership_image' => 'http://127.0.0.1:8000/storage/ownership_doc/image.jpg',
            'month' => rand(1, 12),
            'room' => rand(1, 5),
            'name_admin' => 'Admin2',
            'final_price' => rand(100000, 500000),
            'area' => rand(50, 200),
            'description' => '4وصف للعقار رقم ',
            'status'=>'available'
        ]);
         Property::create([
            'province_id' => 1,
            'seller_id' => 4,
            'name' => 'شقة',
            'type' => 'بيع',
            'month'=>rand(1, 12),
            'ownership_image' => 'http://127.0.0.1:8000/storage/ownership_doc/image.jpg',
            'month' => rand(1, 12),
            'room' => rand(1, 5),
            'name_admin' => 'Admin1',
            'final_price' => rand(100000, 500000),
            'area' => rand(50, 200),
            'description' => '5وصف للعقار رقم ',
            'status'=>'available'
        ]);
    }
}