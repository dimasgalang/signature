<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceClearance extends Model
{
    use HasFactory;

    protected $fillable = [
        'clearance_code',
        'clearance_name',
        'void',
    ];
}
