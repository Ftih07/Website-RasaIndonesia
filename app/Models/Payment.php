<?php

// app/Models/Payment.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $fillable = ['payment_method', 'status', 'transaction_id', 'payment_proof_url'];

    public function order()
    {
        return $this->hasOne(Order::class);
    }
}
