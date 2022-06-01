<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    protected $guard_name = ['sanctum'];

    protected $fillable = [
        'name',
        'email',
        'mobile',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function goods()
    {
        return $this->belongsToMany(Goods::class, 'goods_user', 'user_id', 'goods_id');
    }

    public function roles()
    {
        return $this->morphToMany(Role::class, 'model', 'model_has_roles');
    }

    public function bills()
    {
        return $this->hasMany(Bill::class);
    }

    public function owners()
    {
        return $this->hasMany(Owner::class);
    }

    public function contracts()
    {
        return $this->hasMany(Contract::class);
    }

    /**
     * 是否为超管
     * @return bool
     */
    public function isAdmin()
    {
        return $this->id === 1;
    }

    /**
     * 是否为财务
     */
    public function isFinance()
    {
        return $this->hasRole('Finance');
    }
}
