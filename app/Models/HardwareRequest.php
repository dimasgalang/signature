<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HardwareRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_request_access',
        'hardware_device',
        'qty',
        'status_approved',
    ];
}
