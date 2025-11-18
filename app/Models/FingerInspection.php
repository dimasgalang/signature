<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FingerInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'finger_inspection_id',
        'machine_number',
        'date_of_inspection',
        'person_in_charge',
        'void',
    ];
}
