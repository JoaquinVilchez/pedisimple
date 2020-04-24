<?php

namespace App\Exports;

use Auth;
use App\Category;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;

class CategoriesExport implements FromQuery, WithMapping, WithHeadings
{
    use Exportable;

    public function query()
    {
        return Category::query()->where('restaurant_id', Auth::user()->restaurant->id);
    }

    public function map($category): array
    {
        return [
            $category->name,
            $category->description,
            encrypt($category->id)
        ];
    }

    public function headings(): array
    {
        return [
            'NOMBRE',
            'DESCRIPCION',
            'TOKEN (NO BORRAR)',
        ];
    }

}
