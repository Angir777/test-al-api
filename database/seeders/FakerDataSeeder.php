<?php

namespace Database\Seeders;

use Database\Seeders\Post\PostSeeder;
use Database\Seeders\User\UserSeeder;
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
        // generate faker posts
        $this->call(PostSeeder::class);

        // generate faker users
        $this->call(UserSeeder::class);
    }
}
