<?php

// app/Models/Order.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'cart_id',
        'payment_id',
        'business_id',
        'order_number',
        'subtotal',
        'tax',
        'delivery_fee',
        'order_fee',
        'total_price',
        'gross_price',
        'shipping_address',
        'shipping_lat',
        'shipping_lng', 
        'delivery_note',
        'delivery_option',
        'delivery_status',
        'order_date',
        'partner_id'
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    public function cart()
    {
        return $this->belongsTo(Cart::class);
    }
    public function payment()
    {
        return $this->belongsTo(Payment::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function business()
    {
        return $this->belongsTo(Business::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function partner()
    {
        return $this->belongsTo(User::class, 'partner_id');
    }

    public function testimonial()
    {
        return $this->hasOne(Testimonial::class);
    }

    public function scopeValid($query)
    {
        return $query
            ->whereHas('payment', fn($q) => $q->whereNotIn('status', ['incomplete', 'failed']))
            ->whereNotIn('delivery_status', ['waiting', 'canceled']);
    }
}
