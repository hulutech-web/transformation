<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChargingReport extends Model
{
    use HasFactory;

    protected $fillable = ['id', 'report_date', 'stall_ids', 'remark', 'user_id', 'park_id'];


    protected $casts = [
        'stall_ids' => 'array',
    ];

    public function chargingResults()
    {
        return $this->hasMany(ChargingResult::class);
    }

    public function park()
    {
        return $this->belongsTo(Park::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
