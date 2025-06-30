<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccessRequest extends Model
{
    use HasFactory;
    protected $fillable = [
        'id_request_access',
        'date_of_request',
        'employee_id',
        'approval_id',
        'approval_level',
        'approval_date',
        'approval_progress',
        'document_name',
        'original_name',
        'token',
        'status',
        'base64',
        'void',
    ];
}
