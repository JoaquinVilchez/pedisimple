<?php

use Illuminate\Database\Seeder;
use App\ShopCategory;

class ShopCategorySeeder extends Seeder
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
            ShopCategory::create([
                'name' => $categories[$i],
                'description' => 'Descripcion '.$i,
                'status' => 'active'
            ]);
        }
    }
}
