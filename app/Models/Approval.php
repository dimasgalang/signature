<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Approval extends Model
{
    use HasFactory;
    public $table = "approval";
    protected $fillable = [
        'preparer_id',
        'document_name',
        'original_name',
        'base64',
        'approval_id',
        'approval_level',
        'approval_date',
        'approval_progress',
        'document_approve',
        'approval_base64',
        'status',
        'token',
        'void'
    ];
}
