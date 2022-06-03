<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CarReport extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $casts = [
        'repair_project' => 'array',
        'content_brief' => 'array',
        'attachment' => 'array'
    ];
}
