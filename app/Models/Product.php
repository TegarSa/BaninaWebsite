<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';

    const UPDATED_AT = null;

    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'price_min',
        'price_max',
        'shopee_url',
        'is_featured',
        'is_active',
        'sort_order'
    ];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function primaryImage()
    {
        return $this->hasOne(ProductImage::class)
            ->where('is_primary', 1);
    }
}