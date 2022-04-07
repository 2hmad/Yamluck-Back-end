<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    use HasFactory;
    public $table = 'categories';
    protected $fillable = [
        'id',
        'title_ar',
        'title_en',
        'icon',
    ];
    protected $hidden = [];
    public $timestamps = false;

    public function subCategory()
    {
        return $this->hasMany(SubCategories::class, 'category_id');
    }
}
