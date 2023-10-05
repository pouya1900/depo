<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Mine extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'balance',
    ];

    public function buys()
    {
        return $this->hasMany(Buy::class, 'mine_id');
    }

}
