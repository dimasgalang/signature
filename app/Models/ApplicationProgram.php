<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationProgram extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_request_access',
        'application_name',
        'login_name',
        'status_approved',
    ];
}
