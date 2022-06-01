<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Owner extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $appends = ['build_name'];

    protected $casts = [
        'id_card_copy' => 'array',
        'mutual_person_id_photocopy' => 'array',
        'examination_prove' => 'array',
        'source_property_right_card_to_prove' => 'array',
        'new_apartment' => 'array',
        'report_surveying_mapp' => 'array',
        'only_room_query_report' => 'array',
        'residence_booklet' => 'array',
        'purchase_tax_invoice' => 'array',
        'deed_tax_ticket' => 'array',
    ];
    /**
     * 模块版本
     * @return mixed
     */
    public function getBuildNameAttribute()
    {
        return $this->build()->pluck('name');
    }

    public function build()
    {
        return $this->belongsTo(Build::class);
    }

    public function unit()
    {
        return $this->belongsTo(Unit::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }
}
