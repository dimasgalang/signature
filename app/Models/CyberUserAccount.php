<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CyberUserAccount extends Model
{
    use HasFactory;

    protected $fillable = [
        'deactivation_request_id',
        'date_of_request',
        'approval_id',
        'preparer_id',
        'approval_level',
        'approval_progress',
        'approval_date',
        'token',
        'document_name',
        'original_name',
        'deactivate',
        'start_date',
        'end_date',
        'reason_id',
        'employee_id',
        'comment',
        'status',
        'void',
    ];
}
