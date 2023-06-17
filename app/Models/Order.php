<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $table = "orders";
    protected $fillable = [
        'name',
        'phoneNum',
        'email',
        'address',
        'city',
        'state',
        'zip',
        'gross_amount',
        'payment_mode',
        'pdf_url',
        'status',
    ];
    protected $with = ['orderItems'];

    public function orderitems()
    {
        return $this->hasMany(OrderItems::class, 'order_id', 'id');
    }

    public function order()
    {
        return $this->belongsTo(OrderItems::class, 'order_id', 'id');
    }
}
