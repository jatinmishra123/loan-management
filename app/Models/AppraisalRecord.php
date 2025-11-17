<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AppraisalRecord extends Model
{
    protected $fillable = [
        'customer_id',
        'gold_items_snapshot',
        'total_value',
        'status',
        'downloaded_at'
    ];

public function customer()
{
    return $this->belongsTo(\App\Models\Customer::class, 'customer_id');
}
}

