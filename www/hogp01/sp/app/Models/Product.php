<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['category_id', 'name', 'description', 'price', 'properties', 'stock'];

    protected $casts = [
        'properties' => 'array',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
