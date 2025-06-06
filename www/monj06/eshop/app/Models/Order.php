<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'price',
        'user_id',
        'status',
        'street',
        'postal_code',
        'city',
        'delivery',
        'payment',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
