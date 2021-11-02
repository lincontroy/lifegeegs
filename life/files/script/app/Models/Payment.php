<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;
    public function getway()
    {
        return $this->belongsTo(Getway::class, 'getway_id', 'id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    
    public function request()
    {
        return $this->belongsTo(Request::class, 'request_id', 'id')->with('requestmeta');
    }


    public function request_is_test()
    {
        return $this->belongsTo(Request::class, 'request_id', 'id')->select('id','is_test');
    }

    public function meta()
    {
        return $this->hasOne(Paymentmeta::class, 'payment_id', 'id')->where('key','payment_meta');
    }

    // public function getwaywithfraudcheck()
    // {
    //     return $this->belongsTo(Usergetway::class, 'getway_id', 'id')->with('getway_info')->whereHas('getway_info')->select('id','name','production','sandbox','getway_id');
    // }

    public function getway_info(){
        return $this->belongsTo('App\Models\Getway','getway_id', 'id')->with('usercreds')->where('fraud_checker', 1)->select('id','namespace');
    }
}
