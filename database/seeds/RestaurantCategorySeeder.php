<?php

use Illuminate\Database\Seeder;
use App\RestaurantCategory;

class RestaurantCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categories = array('Empanadas', 'Pizzas', 'Ensaladas', 'Hamburguesas', 'Helados', 'Lomitos', 'Menu del dia', 'Milanesas', 'Papas Fritas', 'Parrilla', 'Pastas', 'Pescados y Mariscos', 'Picadas', 'Pollo', 'Postres', 'Sandwiches');
        
        for ($i=0; $i < count($categories); $i++) { 
            RestaurantCategory::create([
                'name' => $categories[$i],
                'state' => 'active'
            ]);
        }
    }
}
