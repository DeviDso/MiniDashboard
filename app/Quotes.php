<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Quotes extends Model
{
    protected $fillable = ['user_id', 'client_id', 'delivery_price', 'note'];

    public function data(){
        return $this->hasMany(QuotesData::class, 'quote_id', 'id');
    }

    public function client(){
        return $this->belongsTo(Client::class);
    }

    public function totalValue(){
        $list = $this->hasMany(QuotesData::class);

        return $list;
    }
}
