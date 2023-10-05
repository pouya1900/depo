<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sell extends Model
{
    use HasFactory;


    protected $fillable = [
        'sand_id',
        'user_id',
        'weight',
        'price',
        'total',
        'paid',
        'cash',
        'balance',
        'date',
    ];

    public function sand()
    {
        return $this->belongsTo(Sand::class, 'sand_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

}
