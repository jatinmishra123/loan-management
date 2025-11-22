<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SecondGoldItem extends Model
{
    protected $fillable = [
        'description',
        'ledger_folio_no',
        'quantity',
        'gross_weight',
        'stone_weight',
        'net_weight',
        'purity',
        'rate_per_gram',
        'image',
        'remarks'
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
