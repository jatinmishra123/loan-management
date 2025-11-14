<?php

namespace App\Models;

use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    protected $fillable = [
        'role_id',
        'name',
        'email',
        'address',
        'account_number',
        'password',
        'phone',
        'role',
        'is_active',
        'last_login_at',
    ];

    protected $hidden = ['password', 'remember_token'];

    public function isSuperAdmin(): bool
    {
        return $this->role_id == 1 || $this->role === 'super_admin';
    }

    public function isAdmin(): bool
    {
        return $this->role_id == 2 || $this->role === 'admin';
    }

    public function isActive(): bool
    {
        return (bool) $this->is_active;
    }
}
