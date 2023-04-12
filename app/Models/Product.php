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
        'photo',
        'status'
    ];
    protected $with = ['category'];
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
    public function brand()
    {
        return $this->belongsTo(Category::class, 'brand_id', 'id');
    }

    public function colors()
    {
        return $this->belongsToMany(Color::class, 'product_color')->withTimestamps();
    }
}
