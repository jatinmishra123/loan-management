<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GoldItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id',
        'customer_id',
        'description',
        'quantity',
        'gross_weight',
        'stone_weight',
        'net_weight',
        'purity',
        'rate_per_gram',
        'market_value',
        'remarks',
        'image',
    ];

    /**
     * Casts
     */
    protected $casts = [
        'quantity'      => 'integer',
        'gross_weight'  => 'float',
        'stone_weight'  => 'float',
        'net_weight'    => 'float',
        'rate_per_gram' => 'float',
        'market_value'  => 'float',
    ];

    /**
     * Relationship: Each gold item belongs to one customer
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
