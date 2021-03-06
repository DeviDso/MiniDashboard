<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['user_id', 'client_id', 'status_id', 'delivery_price', 'note', 'confirmed', 'deadline', 'payment_term', 'credit_term', 'courier'];

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function status(){
        return $this->belongsTo(OrderStatus::class, 'status_id', 'id');
    }

    public function data(){
        return $this->hasMany(OrderData::class);
    }

    public function user(){
        return $this->belongsTo(User::class);
    }
}
