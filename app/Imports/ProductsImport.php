<?php

namespace App\Imports;

use App\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Auth;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name' => $row[0],
            'details' => $row[1],
            'price' => $row[2],
            'category' => $row[3],
            'product_id' => $row[4]
        ]);
    }
}