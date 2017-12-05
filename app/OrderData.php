<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity', 'price'];

    protected $table = 'orders_data';

    public function order(){
        return $this->belongsTo(Order::class);
    }

    public function product(){
        return $this->belongsTo(Product::class);
    }

}
