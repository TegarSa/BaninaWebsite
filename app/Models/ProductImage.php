<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductImage extends Model
{
    protected $table = 'product_images';
    
    public $timestamps = false;

    protected $fillable = [
        'product_id',
        'image',
        'is_primary',
        'sort_order',
        'created_at'
    ];

    protected static function boot()
    {
        parent::boot();
        
        static::creating(function ($image) {
            $image->created_at = now();
        });
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}