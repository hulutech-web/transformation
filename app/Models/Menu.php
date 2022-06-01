<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
//引入NodeTrait
use Kalnoy\Nestedset\NodeTrait;
class Menu extends Model
{
    use HasFactory,NodeTrait;

    public $fillable = ['id', 'parent_id','icon', 'meta', 'name', 'path', '_lft', '_rgt'];
    public $casts = [
        'meta' => 'array'
    ];
}
