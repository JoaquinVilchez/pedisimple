<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;

class ProductsImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'details' => $row[0],
            'price' => $row[0],
            'category_id' => $row[0],
            'restaurant_id' => Auth::user()->restaurant->id,
        ]);
    }
}
