<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Users extends Model
{
    use HasFactory;

    public $table = 'users';
    protected $fillable = [
        "id",
        'full_name',
        'nick_name',
        'email',
        'phone',
        'country',
        'city',
        'nationality',
        'birthdate',
        'interest',
        'password',
        'facebook_id',
        'google_id',
        'apple_id',
        'token',
        'pic',
        'block',
        'verified'
    ];
    protected $hidden = [
        'password',
    ];
    public $timestamps = false;

    public function subscribe()
    {
        return $this->hasOne(Subscribe::class, 'user_id');
    }
    public function winner()
    {
        return $this->hasOne(Winner::class, 'user_id');
    }
    public function country()
    {
        return $this->hasOne(Countries::class, 'id');
    }
}
