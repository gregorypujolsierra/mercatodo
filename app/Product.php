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

    /**
     * @param $query
     * @param $name
     * @return mixed
     *
     * @todo What are these functions supposed to return?
     */
    public function scopeNameLike($query, $name)
    {
        if ($name) {
            return $query->where('name', 'like', "%$name%");
        }
    }

    /**
     * @param $query
     * @param $price
     * @return mixed
     */
    public function scopePriceGreaterThan($query, $price)
    {
        if ($price) {
            return $query->where('price', '>', $price - 1);
        }
    }

    /**
     * @param $query
     * @param $price
     * @return mixed
     */
    public function scopePriceLessThan($query, $price)
    {
        if ($price) {
            return $query->where('price', '<', $price + 1);
        }
    }
}
