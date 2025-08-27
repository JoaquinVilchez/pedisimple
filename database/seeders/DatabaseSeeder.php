<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\ProvinceSeeder;
use Database\Seeders\CitySeeder;
use Database\Seeders\RestaurantSeeder;
use Database\Seeders\AddressSeeder;
use Database\Seeders\OpeningDateTimeSeeder;
use Database\Seeders\RestaurantCategorySeeder;
use Database\Seeders\CategorySeeder;
use Database\Seeders\ProductSeeder;
use Database\Seeders\OrderSeeder;
use Database\Seeders\LineItemSeeder;
use Database\Seeders\RelationRestaurantCategory;
use Database\Seeders\InvitationSeeder;

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
        $this->call(ProvinceSeeder::class);
        $this->call(CitySeeder::class);
        $this->call(RestaurantSeeder::class);
        $this->call(AddressSeeder::class);
        $this->call(OpeningDateTimeSeeder::class);
        $this->call(RestaurantCategorySeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ProductSeeder::class);
        $this->call(OrderSeeder::class);
        $this->call(LineItemSeeder::class);
        $this->call(RelationRestaurantCategory::class);
        $this->call(InvitationSeeder::class);
    }
}
