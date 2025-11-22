<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SMSLog extends Model
{
    protected $table = 'sms_logs';

    protected $fillable = [
        'admin_id',
        'agent_id',
        'mobile_number',
        'message',
        'status',
    ];
}
