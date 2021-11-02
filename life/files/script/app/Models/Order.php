<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    // Relation To plan
    public function plan()
    {
        return $this->belongsTo(Plan::class, 'plan_id', 'id');
    }

    public function getway()
    {
        return $this->belongsTo(Getway::class, 'getway_id', 'id');
    }

    public function getwaywithfraudcheck()
    {
        return $this->belongsTo(Getway::class, 'getway_id', 'id')->where('fraud_checker', 1)->select('id','name','namespace','test_mode','data');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    public function meta()
    {
        return $this->hasOne(Ordermeta::class); 
    }

}
