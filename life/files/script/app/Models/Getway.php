<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Getway extends Model
{
    use HasFactory;

    public function usergetwaycreds(){
        return $this->hasOne('App\Models\Usergetway')->with('currencygetway')->where('user_id', Auth::id());
    }

    public function usergetway(){
        return $this->hasOne('App\Models\Usergetway')->with('currencygetway');
    }

    public function usercreds(){
        return $this->hasOne('App\Models\Usergetway');
    }
}
