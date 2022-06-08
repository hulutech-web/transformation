<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stall extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'number', 'location', 'park_id'];


    public $appends = ['park_name'];

//    仅取park_id对应的park的name，不加载整个park模型数据

    public function getParkNameAttribute()
    {
        return $this->park->name;
    }

    public function park()
    {
        return $this->belongsTo(Park::class);
    }

    public function ChargingPile()
    {
        return $this->hasOne(ChargingPile::class);
    }
}
