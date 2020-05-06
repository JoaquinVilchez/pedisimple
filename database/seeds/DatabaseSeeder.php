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
