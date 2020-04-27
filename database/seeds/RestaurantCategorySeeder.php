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
        $categories = array(
            'Bebidas',
            'Comida Vegetariana',
            'Carnes',
            'Celíacos',
            'Desayunos',
            'Dulce',
            'Empanadas',
            'Ensaladas',
            'Hamburguesas',
            'Helados',
            'Lomitos',
            'Menú del día',
            'Meriendas',
            'Milanesas',
            'Papas fritas',
            'Parrilla',
            'Pastas',
            'Pescados',
            'Picadas',
            'Pizzas',
            'Pollo',
            'Postres',
            'Sandwiches',
            'Sushi',
            'Tartas',
            'Woks'
        );
        
        for ($i=0; $i < count($categories); $i++) { 
            RestaurantCategory::create([
                'name' => $categories[$i],
                'state' => 'active'
            ]);
        }
    }
}
