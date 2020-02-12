<?php

namespace Fast\RealEstate\Seeders;

use Illuminate\Database\Seeder;

class RealEstateSeeder extends Seeder
{
    public function run()
    {
        $this->call(CategorySeeder::class);
    }
}
