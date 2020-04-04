<?php

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
        $this->call(UserSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(ShopSeeder::class);
        $this->call(OpeningDateTimeSeeder::class);
        $this->call(ShopCategorySeeder::class);
    }
}
