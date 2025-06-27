<?php

namespace Database\Seeders;

use App\Models\Image;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddImageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for($i=1;$i<6;$i++)
         for($j=1;$j<6;$j++)
        Image::create([
                 'property_id' =>$i,
                    'image_path' => "http://127.0.0.1:8000/storage/property_images/prop$i$j.jpg",
        ]);
    }
}