<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'name',
        'description',
        'price',
        'stock',
        'enabled',
        'notes',
    ];

    public function scopeNameLike($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%$name%");
        }
    }

    public function scopePriceGreaterThan($query, $price)
    {
        if ($price) {
            return $query->where('price', '>', $price - 1);
        }
    }

    public function scopePriceLessThan($query, $price)
    {
        if ($price) {
            return $query->where('price', '<', $price + 1);
        }
    }
}
