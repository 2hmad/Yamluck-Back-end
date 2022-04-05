<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AgesRepeat extends Model
{
    use HasFactory;
    public $table = 'ages_reports';
    protected $fillable = [
        'id',
        'year',
        'repeat',
    ];
    protected $hidden = [];
    public $timestamps = false;
}
