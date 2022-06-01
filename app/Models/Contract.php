<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    protected $fillable =
        ['id',
            'uuid',
            'principal_name',
            'principal_phone',
            'principal_idNo',
            'principal_add_name',
            'principal_add_phone',
            'principal_add_idNo',
            'home_address',
            'agency_fee',
            'one_time_charges',
            'rest',
            'nature_the_land',
            'replace_land',
            'difference_cost',
            'supplementary_provision',
            'owner_id',
            'user_id'
        ];
    protected $appends = ['owner_name'];

    public function owner()
    {
        return $this->belongsTo(Owner::class);
    }

    public function getOwnerNameAttribute()
    {
        return $this->owner()->pluck('householder_name')->first();
    }
}
