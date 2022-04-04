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
        "owner_name",
        "owner_phone",
        "details_ar",
        "details_en",
        "price",
        "share_price",
        "start_date",
        "end_date",
        "max_subs",
        "curr_subs",
        "conditions_ar",
        "conditions_en",
        "category_id",
        "sub_category_id",
        "sub_sub_category_id",
        "pic_one",
        "pic_two",
        "pic_three",
        "pic_four",
        "pic_five",
        "pic_six",
        'country',
        'city',
        "video_link",
        "publish_date"
    ];
    protected $hidden = [];
    public $timestamps = false;
}
