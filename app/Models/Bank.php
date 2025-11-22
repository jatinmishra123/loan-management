<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bank extends Model
{
    use HasFactory;

    protected $table = 'banks';

    /**
     * The attributes that are mass assignable.
     */
 protected $fillable = [
    'admin_id',
    'bank',
    'address',
    'ifsc_code',
    'bank_code',
   
];


    /**
     * The attributes that should be cast.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * ✅ A bank has many branches.
     */
    public function branches()
    {
        return $this->hasMany(Branch::class, 'bank_id');
    }

    /**
     * ✅ A bank has many customers (optional but useful)
     */
    public function customers()
    {
        return $this->hasMany(Customer::class, 'bank_id');
    }

    /**
     * ✅ Scope to get only active banks.
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}
