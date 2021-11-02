<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    use HasFactory;
    public $timestamps = false;
    protected $table = "currencies";
    protected $primaryKey = "id";
    protected $fillable = [
        "name",
        "symbol",
        "position",
        "status",
    ];

}
