<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Plan extends Model
{
    use HasFactory;
    protected $table = "plans";
    protected $primaryKey = "id";
    protected $fillable = [
        "name",
        "price",
        "duration",
        "captcha",
        "menual_req",
        "monthly_req",
        "daily_req",
        "mail_activity",
        "is_trial",
        "storage_limit",
        "fraud_check",
        "is_featured",
        "is_auto",
        "is_default",
        "status",
    ];

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    public function acitveorders()
    {
        return $this->hasMany(Order::class)->where('status',1);
    }
}
