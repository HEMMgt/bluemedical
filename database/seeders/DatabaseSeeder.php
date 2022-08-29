<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
      

        //crea valores por default
        $this->call(UsersSeeder::class);
        $this->call(CarsSeeder::class);
    }
}
