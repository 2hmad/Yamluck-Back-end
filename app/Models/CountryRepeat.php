<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CountryRepeat extends Model
{
    use HasFactory;
    public $table = 'countries_reports';
    protected $fillable = [
        'id',
        'country',
        'repeat',
    ];
    protected $hidden = [];
    public $timestamps = false;
}
