<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_request_access',
        'email_address',
        'other_request',
        'type',
        'purpose',
        'restriction',
        'status_approved',
    ];
}
