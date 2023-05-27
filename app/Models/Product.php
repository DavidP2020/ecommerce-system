<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $fillable = [
        'category_id',
        'name',
        'slug',
        'description',
        'brand_id',
        'trending',
        'wishlist',
        'weight',
        'unit',
        'unit',
        'photo',
        'status'
    ];
    protected $with = ['category', 'product_color', 'brand'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color')->withTimestamps();
    }

    public function product_color()
    {
        return $this->belongsTo(Product_Color::class, 'id', 'product_id');
    }
}
