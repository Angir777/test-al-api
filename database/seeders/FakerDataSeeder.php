<?php

namespace Database\Seeders;

use Database\Seeders\Post\PostSeeder;
use Illuminate\Database\Seeder;

class FakerDataSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(PostSeeder::class);
    }
}
