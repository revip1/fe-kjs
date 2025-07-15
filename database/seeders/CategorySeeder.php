<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = ['Kapal', 'Port', 'Cargo', 'Vessel', 'SeaPort'];

        foreach ($categories as $name) {
            Category::create(['nama' => $name]);
        }
    }
}
