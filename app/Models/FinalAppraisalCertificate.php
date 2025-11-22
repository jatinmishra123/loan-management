<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FinalAppraisalCertificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'second_appraisal_id',
        'ledger_folio_no',
        'gold_loan_account_no',
        'borrower_name',
        'generated_pdf_path',
    ];

    /**
     * Define the relationship to the SecondAppraisal record (raw data).
     */
    public function secondAppraisal()
    {
        return $this->belongsTo(SecondAppraisal::class);
    }

    /**
     * Optional: Define relationship to the Admin who created the record.
     */
    public function admin()
    {
        return $this->belongsTo(Admin::class);
    }
}