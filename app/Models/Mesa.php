<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Enums\TableStatus;

class Mesa extends Model
{
    use SoftDeletes;

    protected $table = 'tables';
    public $timestamps = false;

    protected $fillable = [
        'number',
        'capacity',
        'status'
    ];

    protected $casts = [
        'status' => TableStatus::class,
    ];
}
