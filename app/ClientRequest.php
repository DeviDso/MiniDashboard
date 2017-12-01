<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    protected $fillable = ['user_id', 'client_id', 'request_type_id', 'request_status_id', 'note'];

    protected $table = 'clients_requests';
}
