<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SmtpServer extends Model
{
    use HasFactory;
    protected $fillable = [
        'name',
        'host',
        'port',
        'encryption',
        'username',
        'password',
        'daily_limit',
        'monthly_limit',
        'daily_usage',
        'monthly_usage',
        'is_active',
    ];
}
