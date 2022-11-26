<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsQueue extends Model
{
    protected $table = 'sms_queue';
    protected $fillable = [
        'sms','from','to','sent',
    ];
}
