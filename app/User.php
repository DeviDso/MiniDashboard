<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'surname', 'phone', 'role_id', 'api_token'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function role(){
        return $this->hasOne(Role::class);
    }

    public function product(){
        return $this->hasMany(Product::class);
    }

    public function client(){
        return $this->hasMany(Client::class);
    }

    public function clientRequest(){
        return $this->hasMany(ClientRequest::class);
    }

    public function order(){
        return $this->hasMany(Order::class);
    }

}
