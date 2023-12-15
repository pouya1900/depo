<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SendCheck extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'own_name',
        'number',
        'bank',
        'amount',
        'date',
    ];

}
