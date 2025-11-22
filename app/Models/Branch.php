<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    use HasFactory;

    protected $table = 'branches';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'admin_id',
        'bank_id',
        'cash_incharge',
        'branch_address',
        'branch_email',
        'is_active',
    ];

    /**
     * Cast attributes to specific types
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relationship: Each branch belongs to one bank
     */
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    /**
     * Relationship: Branch has many customers
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'branch_id');
    }

    /**
     * Scope: Only active branches
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', 1);
    }
}
