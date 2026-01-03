<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SessionLog extends Model
{
    protected $table = 'sessions_log';

    protected $fillable = ['user_id', 'ip_address', 'login_at'];

    public $timestamps = false;


    protected $casts = [
        'login_at' => 'datetime',
    ];
}
