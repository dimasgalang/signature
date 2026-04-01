<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stampel extends Model
{
    use HasFactory;
    public $table = "stampel";
    protected $fillable = [
        'preparer_id',
        'document_name',
        'original_name',
        'base64',
        'document_stamp',
        'stamp_base64',
        'token',
        'void'
    ];
}
