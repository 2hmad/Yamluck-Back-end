<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cities extends Model
{
    use HasFactory;
    public $table = 'cities';
    protected $fillable = [
        'id',
        'name_ar',
        'name_en',
        'country_id'
    ];
    protected $hidden = [
        'name_fr',
        'code'
    ];
    public $timestamps = false;
}
