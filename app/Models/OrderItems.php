<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItems extends Model
{
    use HasFactory;
    protected $table = "orders_items";
    protected $fillable = [
        'order_id',
        'product_id',
        'color',
        'qty',
        'price',
    ];
    protected $with = ['product'];
    public function product()
    {
        return $this->belongsTo(Product_Color::class, 'product_id', 'id');
    }
}
