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
        'alter_address',            // ✅ Added (from your View)
        'date',
        'bank_id',
        'branch_id',
        'cash_incharge',
        'cash_incharge_additional', // ✅ Added (from your View)
        'account_number',
        'loan_number',
        'saving_number',
        'ladger_number',
        'ledger_folio_no',
        'gold_loan_alc_no',
        'tenure_days',              // ✅ Added (from your View)
        'paid',                     // ✅ Added (from your View)
        'customer_remarks',         // ✅ Added (from your View)
        'is_active',
        'password',                 // Optional: Only if customers login
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

    // ✅ Customer belongs to a Bank
    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    // ✅ Customer belongs to a Branch
    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }

    // ✅ Customer has many Gold Items
    public function goldItems()
    {
        return $this->hasMany(GoldItem::class, 'customer_id');
    }

    // ✅ Customer belongs to an Admin (User)
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id', 'id');
    }
}