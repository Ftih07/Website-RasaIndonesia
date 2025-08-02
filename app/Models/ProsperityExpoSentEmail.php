<?php

// app/Models/ProsperityExpoSentEmail.php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProsperityExpoSentEmail extends Model
{
    protected $fillable = [
        'recipient_name',
        'email',
        'company_brand',
        'participant_type',
        'link',
        'sent_at',
    ];

    protected $casts = [
        'sent_at' => 'datetime',
    ];
}
