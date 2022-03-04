<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Winner extends Model
{
    use HasFactory;
    public $table = "winners";
    protected $fillable = [
        "user_id",
        "product_id",
        "date"
    ];
    protected $hidden = [];
    public $timestamps = false;
}
