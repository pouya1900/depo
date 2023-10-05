<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Sand extends Model
{
    use HasFactory;

    protected $table = "sands";

    protected $fillable = [
        'name',
        'weight',
        'price',
    ];

    public function sells()
    {
        return $this->hasMany(Sell::class, 'sand_id');
    }

    public function buys()
    {
        return $this->hasMany(Buy::class, 'sand_id');
    }

}
