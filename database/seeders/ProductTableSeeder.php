<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class ProductTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //factory(App\Models\Product::class, 100)->create();
        \App\Models\Product::factory()->count(100)->create(); 
    }
}
