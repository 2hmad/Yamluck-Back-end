<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Offers extends Model
{
    use HasFactory;

    protected $table = "offers";
    protected $fillable = [
        "title_ar",
        "title_en",
        "details_ar",
        "details_en",
        "price",
        "share_price",
        "start_time",
        "end_time",
        "max_subs",
        "curr_subs",
        "conditions_ar",
        "conditions_en",
        "pic_one",
        "pic_two",
        "pic_three",
        "video_link",
        "publish_date"
    ];
    protected $hidden = [];
    public $timestamps = false;
}
