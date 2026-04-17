<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'clients';

    protected $fillable = [
        'name',
        'identification',
        'email',
        'phone',
    ];

    // Pedidos realizados por este cliente
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
