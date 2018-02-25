<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'street', 'city', 'post_code', 'country', 'contact_person',
     'delivery_street', 'delivery_city', 'delivery_post_code', 'delivery_country', 'note', 'courier_account',
     'credit_amount', 'payment_term', 'vat'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function requests(){
        return $this->hasMany(ClientRequest::class)
                    ->orderBy('created_at', 'dsc')
                    ->with('requestStatus')
                    ->with('requestType');
    }

    public function orders(){
        return $this->hasMany(Order::class)
                    ->orderBy('created_at', 'dsc')
                    ->with('data')
                    ->with('data.product')
                    ->with('status');
    }

    public function quote(){
        return $this->hasMany(Quotes::class)->with('data');
    }
}
