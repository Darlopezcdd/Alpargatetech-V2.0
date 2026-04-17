<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class FixedAsset extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'fixed_assets';

    protected $fillable = [
        'name',
        'description',
        'quantity',
        'status',
    ];
}
