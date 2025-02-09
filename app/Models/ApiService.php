<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ApiService extends Model
{
    protected $fillable = [
        'name',
        'type',
        'base_url',
        'api_key',
        'auth_method',
        'extra_data',
        'daily_limit',
        'monthly_limit',
        'daily_usage',
        'monthly_usage',
        'is_active',
    ];

    protected $casts = [
        'extra_data' => 'array', // Automatically decode JSON field
    ];
}
