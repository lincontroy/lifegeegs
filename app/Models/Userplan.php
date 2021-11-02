<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Userplan extends Model
{
    use HasFactory;
    protected $table = "userplans";
    protected $primaryKey = "id";
    protected $fillable = [
        "user_id",
        "name",
        "captcha",
        "menual_req",
        "monthly_req",
        "daily_req",
        "mail_activity",
        "storage_limit",
        "fraud_check",
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id')->with('meta');
    }
}
