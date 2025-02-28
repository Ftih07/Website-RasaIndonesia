<?php

namespace App\Models; // Defines the namespace of this model, following Laravel's MVC structure

use Illuminate\Database\Eloquent\Factories\HasFactory; // Imports the HasFactory trait for factory support
use Illuminate\Database\Eloquent\Model; // Imports the base Eloquent Model class

class QnA extends Model
{
    // Enables the factory feature for this model
    use HasFactory;

    // Specifies the attributes that are mass assignable
    protected $fillable = ['question', 'answer'];
}
