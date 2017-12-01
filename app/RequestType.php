<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RequestType extends Model
{
    protected $fillable = ['name'];

    protected $table = 'request_type';
}
