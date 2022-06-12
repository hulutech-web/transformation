<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingResult extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'charging_pile_id', 'charging_report_id', 'result'];

    protected $casts = [
        'result' => 'array',
    ];

    public function chargingReport()
    {
        return $this->belongsTo(ChargingReport::class);
    }

    public function chargingPile()
    {
        return $this->belongsTo(ChargingPile::class);
    }
}
