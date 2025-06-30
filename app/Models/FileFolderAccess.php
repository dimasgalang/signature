<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FileFolderAccess extends Model
{
    use HasFactory;

    protected $fillable = [
        'id_request_access',
        'file_folder_name',
        'read',
        'write',
        'status_approved',
    ];
}
