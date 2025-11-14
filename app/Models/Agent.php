<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Agent extends Authenticatable
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'bank_id',
        'branch_id',
        'designation',
        'name',
        'email',
        'password',
        'mobile_number',
        'whatsapp_number',
        'image',
        'is_active',
        'address',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    /** BANK RELATION */
    public function bank()
    {
        return $this->belongsTo(Bank::class, 'bank_id');
    }

    /** BRANCH RELATION */
    public function branch()
    {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    /** TOKENS (if you use API tokens for agents) */
    public function tokens()
    {
        return $this->hasMany(AgentToken::class, 'agent_id');
    }

    /** AGENT ADDRESS ACCESSOR */
    public function getFullAddressAttribute()
    {
        return $this->address ? $this->address : 'N/A';
    }
}
