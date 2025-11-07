<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnswerCompInspectQuestionnaire extends Model
{
    use HasFactory;

    protected $fillable = [
        'computer_inspection_id',
        'assets_number',
        'questionnaire_id',
        'answer',
        'notes',
    ];
}
