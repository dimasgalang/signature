<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Commitment extends Model
{
    use HasFactory;
    public $table = "commitment";
    protected $fillable = [
        'npk',
        'name',
        'dept',
        'position',
        'date',
        'joining_date',
        'document_name',
        'original_name',
        'base64',
        'void'
    ];
}
