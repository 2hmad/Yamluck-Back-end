<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Favorites extends Model
{
    use HasFactory;
    public $table = 'favs';
    protected $fillable = [
        'id',
        'user',
        'product',
    ];
    protected $hidden = [];
    public $timestamps = false;

    public function product()
    {
        return $this->hasOne(Offers::class, 'id', 'product');
    }
}
