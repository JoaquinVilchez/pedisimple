<?php

namespace App\Exports;

use Auth;
use App\Product;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProductsExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Product::query()->where('restaurant_id', Auth::user()->restaurant->id)->where('temporary',false)->where('state', '!=', 'removed');
    }

    public function map($product): array
    {
        return [
            $product->name,
            $product->details,
            $product->price,
            $product->category->name,
            encrypt($product->id)
        ];
    }

    public function headings(): array
    {
        return [
            'NOMBRE',
            'DESCRIPCION',
            'PRECIO',
            'CATEGORIA',
            'TOKEN (NO BORRAR)',
        ];
    }

}
