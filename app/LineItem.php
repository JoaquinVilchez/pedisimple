<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LineItem extends Model
{
    protected $guarded = [];
    protected $casts = ['variants'=>'array'];

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

    public function showVariants(){
        $variants = [];
        foreach (Variant::find($this->variants) as $variant) {
            array_push($variants,$variant->name);
        }
        return $variants;
    }
    
}
