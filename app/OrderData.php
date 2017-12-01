<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderData extends Model
{
    protected $fillable = ['order_id', 'product_id', 'quantity'];

    protected $table = 'orders_data';
}
