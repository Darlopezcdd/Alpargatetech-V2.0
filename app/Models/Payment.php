<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    public $timestamps = true;
    protected $fillable = ['order_id', 'amount', 'payment_method'];
}
