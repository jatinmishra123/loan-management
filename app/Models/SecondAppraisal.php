<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondAppraisal extends Model
{
    protected $fillable = [
        'admin_id',
        'gold_loan_account_no',
        'ledger_folio_no',
        'name_address_first_appraisal',
        'second_appraisal_date',
        'bank_id',
        'branch_id',
        'branch_code',
        'in_present_of',
        'cash_incharge',
        'joint_custody_officer'
    ];

    // Remove customer() relationship
    // public function customer() {}

    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }

    public function bank()
    {
        return $this->belongsTo(Bank::class);
    }

    public function branch()
    {
        return $this->belongsTo(Branch::class);
    }
  public function items()
{
    return $this->hasMany(SecondGoldItem::class, 'ledger_folio_no', 'ledger_folio_no');
}



}
