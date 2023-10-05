<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Buy extends Model
{
    use HasFactory;


    protected $fillable = [
        'sand_id',
        'mine_id',
        'real_weight',
        'mine_weight',
        'price',
        'total',
        'type',
        'car',
        'date',
    ];

    public function sand()
    {
        return $this->belongsTo(Sand::class, 'sand_id');
    }

    public function mine()
    {
        return $this->belongsTo(Mine::class, 'mine_id');
    }

}
