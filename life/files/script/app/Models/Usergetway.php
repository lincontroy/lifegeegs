<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Usergetway extends Model
{
    use HasFactory;

    public function currencygetway(){
        return $this->hasOne('App\Models\Currencygetway')->with('currency');
    }

    public function user(){
        return $this->belongsTo('App\Models\User','user_id', 'id');
    }

    public function getway(){
        return $this->belongsTo('App\Models\Getway','getway_id', 'id');
    }

    public function getway_info(){
        return $this->belongsTo('App\Models\Getway','getway_id', 'id')->where('fraud_checker', 1)->select('id','namespace');
    }
}

