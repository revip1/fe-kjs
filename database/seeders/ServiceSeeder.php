<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Service;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Service::insert([
            ['nama' => 'Stevedoring', 'categories_id' => 1, 'harga' => 20000],
            ['nama' => 'Cargodoring', 'categories_id' => 1, 'harga' => 35000],
            ['nama' => 'Receiving/Delivery', 'categories_id' => 1, 'harga' => 15000],
        ]);
    }
}
