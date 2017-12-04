<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable  = ['category_id', 'name', 'code', 'alternative_code', 'weight', 'quantity', 'price', 'description'];

    public function category(){
        return $this->belongsTo(ProductCategory::class);
    }
}
