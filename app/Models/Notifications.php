<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notifications extends Model
{
    use HasFactory;
    protected $table = "notifications";
    protected $fillable = [
        'user_id',
        'sender',
        'subject_en',
        'subject_ar',
        'content_en',
        'content_ar',
        'date'
    ];
    protected $hidden = [];
    public $timestamps = false;
}
