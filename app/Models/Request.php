<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Request extends Model
{
    use HasFactory;

    public function requestmeta()
    {
        return $this->hasOne('App\Models\Requestmeta', 'request_id', 'id')->where('key', 'request_info');
    }
    public function user()
    {
        return $this->belongsTo("App\Models\User", "user_id", 'id');
    }
}
