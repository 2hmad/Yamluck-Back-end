<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    public $table = 'users';
    protected $fillable = [
        'full_name',
        'nick_name',
        'email',
        'phone',
        'country',
        'city',
        'nationality',
        'age',
        'birthdate',
        'interest',
        'password',
        'facebook_id',
        'google_id',
        'apple_id',
        'token',
        'pic',
        'token'
    ];
    protected $hidden = [
        'password'
    ];
    public $timestamps = false;
}
