<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payments extends Model
{
    use HasFactory;
    protected $table = "payments_invoices";
    protected $fillable = [
        "user_id",
        "invoice_id",
        "bill_to",
        "payment",
        "order_date",
        "description",
        "publisher",
        "price",
    ];
    protected $hidden = [];
    public $timestamps = false;
}
