<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Build extends Model
{
    use HasFactory, SoftDeletes;

    protected $dates = ['deleted_at'];
    public $guarded = [];

    protected $casts = [
        'project_approval_document' => 'array',
        'land_approval_documents' => 'array',
        'planning_construction_permits' => 'array',
        'construction_permit' => 'array',
        'fire_acceptance_report' => 'array',
        'joint_acceptance_report' => 'array',
        'construction_drawing_examination_approval_documents' => 'array',
        'environmental_audit_file' => 'array',
        'project_completion_figure' => 'array'
    ];

    public function units()
    {
        return $this->hasMany(Unit::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }
}
