<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ComputerInspection extends Model
{
    use HasFactory;

    protected $fillable = [
        'computer_inspection_id',
        'assets_number',
        'user',
        'device_name',
        'location',
        'person_in_charge',
        'date_of_inspection',
    ];
}
