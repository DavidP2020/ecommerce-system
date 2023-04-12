<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $table = 'cart';
    protected $guarded = [
        'id'
    ];

    protected $with = ['product'];
    public function product()
    {
        return $this->belongsTo(Product_Color::class, 'product_id', 'id');
    }
}
