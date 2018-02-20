<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class QuotesData extends Model
{
    protected $fillable = ['quote_id', 'name', 'code', 'product_id', 'price', 'quantity', 'note'];

    public function quote(){
        return $this->belongsTo(Quotes::class);
    }
}
