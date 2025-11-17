<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'admin_id',
        'invoice_no',
        'invoice_date',
        'total_amount',
        'amount_in_words',
        'round_off',
        'company_pan',
        'bank_account_no',
        'bank_name',
        'ifsc_code',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
