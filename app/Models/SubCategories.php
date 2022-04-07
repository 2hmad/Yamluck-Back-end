<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubCategories extends Model
{
    use HasFactory;
    public $table = 'sub_categories';
    protected $fillable = [
        'id',
        'title_ar',
        'title_en',
        'category_id',
    ];
    protected $hidden = [];
    public $timestamps = false;
}
