<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerSurveillanceQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'surveillance_system_maintenance_id',
        'questionnaire_id',
        'answer',
    ];
}
