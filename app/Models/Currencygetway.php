<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currencygetway extends Model
{
    use HasFactory;

    public $timestamps = null;

    public function usergetway(){
        return $this->belongsTo('App\Models\Usergetway','usergetway_id', 'id');
    }

    public function currency(){
        return $this->belongsTo('App\Models\Currency','currency_id', 'id');
    }
    
}
