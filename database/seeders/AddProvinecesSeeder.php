<?php

namespace Database\Seeders;

use App\Models\Province;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AddProvinecesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
         $provinces = [
            'دمشق',
            'ريف دمشق',
            'درعا',
            'السويداء',
            'القنيطرة',
            'حمص',
            'حماة',
            'طرطوس',
            'اللاذقية',
            'إدلب',
            'حلب',
            'الرقة',
            'دير الزور',
            'الحسكة',
        ];
        foreach ($provinces as $name)
            Province::create([
                'string' => $name
            ]);
    }
}