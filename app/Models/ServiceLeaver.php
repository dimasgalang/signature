<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceLeaver extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaver_code',
        'leaver_name',
        'void',
    ];
}
