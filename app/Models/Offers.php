<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;

    protected $table = "offers";
    protected $fillable = [
        "title",
        "details",
        "price",
        "share_price",
        "start_time",
        "end_time",
        "max_subs",
        "curr_subs",
        "conditions",
        "pic_one",
        "pic_two",
        "pic_three",
        "publish_date"
    ];
    protected $hidden = [];
    public $timestamps = false;
}
