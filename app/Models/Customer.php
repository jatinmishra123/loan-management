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
    'date',
    'bank_id',
    'branch_id',
    'cash_incharge',
    'account_number',
    'loan_number',
    'saving_number',
    'ladger_number',
    'is_active',
    'ledger_folio_no',
    'gold_loan_alc_no',
];


    /**
     * Attributes hidden from arrays
     */
    protected $hidden = [
        'password',
    ];

    /**
     * Cast attributes
     */
    protected $casts = [
        'is_active' => 'boolean',
        'date' => 'date',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    /**
     * Automatically hash password when setting
     */
    public function setPasswordAttribute($value)
    {
        if (!empty($value)) {
            $this->attributes['password'] = bcrypt($value);
        }
    }

    /**
     * Relationships
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
    public function goldItems()
    {
        return $this->hasMany(\App\Models\GoldItem::class, 'customer_id');
    }
    public function admin()
{
    return $this->belongsTo(\App\Models\Admin::class, 'admin_id', 'id');
}


}
