<?php

namespace App\Imports;

use Auth;
use App\Product;
use Illuminate\Validation\Rule;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\Importable;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class ProductsImport implements ToModel, WithHeadingRow, WithMultipleSheets
{
    use Importable;

    public function model(array $row)
    {
        return new Product([
            'name' => $row['nombre'],
            'details' => $row['descripcion'],
            'price' => $row['precio'],
            'category' => $row['categoria'],
            'variants' => $row['variantes'],
            'product_id' => $row['token (no borrar)']
        ]);
    }

    public function sheets(): array
    {
        return [
            // Select by sheet index
            0 => new ProductsImport(),
        ];
    }
}
