<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $fillable = ['name', 'phone', 'email', 'street', 'city', 'post_code', 'country', 'contact_person'];

    public function user(){
        return $this->belongsTo(User::class);
    }

    public function clientRequest(){
        return $this->hasMany(ClientRequest::class);
    }
}
