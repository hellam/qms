<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SmsQueue extends Model
{
    protected $fillable = [
        'sms','from','to',
    ];
}
