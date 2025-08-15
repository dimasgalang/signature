<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SurveillanceSystemMaintenance extends Model
{
    use HasFactory;

    protected $fillable = [
        'surveillance_system_maintenance_id',
        'date_of_maintenance',
        'number_of_camera',
        'number_of_server',
        'approval_id',
        'preparer_id',
        'approval_level',
        'approval_progress',
        'approval_date',
        'token',
        'document_name',
        'status',
        'void',
    ];
}
