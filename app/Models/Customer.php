<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $table = 'customers';

    /**
     * Mass assignable attributes
     */
    protected $fillable = [
        'admin_id',
        'brauser_name',
        'ralative_name',
        'address',
        'alter_address',
        'date',
        'bank_id',
        'branch_id',
        'cash_incharge',
        'cash_incharge_additional',
        'account_number',
        'loan_number',
        'saving_number',
        'ladger_number',
        'tenure_days',
        'paid',
        'customer_remarks',
        'is_active',
        'password',  // only if you use login
    ];

    /**
     * Attributes hidden from arrays
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'is_active'   => 'boolean',
        'date'        => 'date',
        'paid'        => 'integer',
        'tenure_days' => 'integer',
        'created_at'  => 'datetime',
        'updated_at'  => 'datetime',
    ];

    /**
     * Automatically hash password when setting (Mutator)
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /*
    |--------------------------------------------------------------------------
    | Relationships
    |--------------------------------------------------------------------------
    */

    // Customer belongs to a Bank
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // Customer belongs to a Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // Customer belongs to an Admin (User)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }

    // Gold items (if you need)
    public function goldItems()
    {
        return $this->hasMany(GoldItem::class, 'customer_id');
    }
}
