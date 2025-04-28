<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    use HasFactory;
    public $table = "attachment";
    protected $fillable = [
        'token',
        'document_name',
        'original_name',
        'void'
    ];
}
