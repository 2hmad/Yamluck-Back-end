<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Subscribe extends Model
{
    use HasFactory;
    public $table = "subscribers";
    protected $fillable = [
        "user_id",
        "product_id",
        "date"
    ];
    protected $hidden = [];
    public $timestamps = false;
}
