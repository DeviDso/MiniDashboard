<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientRequest extends Model
{
    protected $fillable = ['user_id', 'client_id', 'request_type_id', 'request_status_id', 'note'];

    protected $table = 'clients_requests';

    public function user(){
        return $this->belongsTo(User::class);
    }
    public function client(){
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
    public function requestStatus(){
        return $this->hasOne(RequestStatus::class, 'id', 'request_status_id');
    }
    public function requestType(){
        return $this->belongsTo(RequestType::class);
    }
}
 
