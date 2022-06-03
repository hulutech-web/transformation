<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReportItem extends Model
{
    use HasFactory;

    protected $casts = [
        'options' => 'array'
    ];

    protected $guarded = [];
}
