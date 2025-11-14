<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AgentToken extends Model
{
    protected $fillable = [
        'agent_id',
        'token',
    ];

    // Relation with Agent
    public function agent()
    {
        return $this->belongsTo(Agent::class, 'agent_id');
    }
}
