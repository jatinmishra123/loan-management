<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SlotBooking extends Model
{
    protected $fillable = [
        'agent_id',
        'created_by',    
        'customer_id',
        'date',
        'time',
        'status',
        'remarks',
    ];

    // Agent Relationship
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }

    // Customer Relationship
    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customer_id');
    }

    // Admin Relationship
    public function admin()
    {
        return $this->belongsTo(Admin::class, 'admin_id');
    }
}
