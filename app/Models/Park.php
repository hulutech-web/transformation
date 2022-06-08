<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Park extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'address', 'phone', 'manager'];

    public function stalls()
    {
        return $this->hasMany(Stall::class);
    }

//    與充電樁關聯
    public function ChargingPile()
    {
        return $this->hasMany(ChargingPile::class);
    }
}
