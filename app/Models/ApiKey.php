<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApiKey extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'organization_id',
        'client_key',
        'secret_key',
        'auth_url',
        'base_url',
        'consent_url',
        'is_active',
    ];
}

