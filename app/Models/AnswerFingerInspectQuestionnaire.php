<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerFingerInspectQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'surveillance_system_maintenance_id',
        'machine_number',
        'date_of_maintenance',
        'questionnaire_id',
        'answer'
    ];
}
