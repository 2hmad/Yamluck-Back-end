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
        "owner_id",
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
        "preview",
        "gift_en",
        "gift_ar",
        "gift_pic",
        "publish_date"
    ];
    protected $hidden = [];
    public $timestamps = false;

    public function country()
    {
        return $this->hasOne(Countries::class, 'id', 'country');
    }
    public function city()
    {
        return $this->hasOne(Cities::class, 'id', 'city');
    }
    public function category()
    {
        return $this->hasOne(Categories::class, 'id', 'category_id');
    }
    public function user()
    {
        return $this->hasOne(Users::class, 'id', 'owner_id');
    }
    public function similar()
    {
        return $this->hasMany(Offers::class, 'category_id', 'category_id');
    }
}
