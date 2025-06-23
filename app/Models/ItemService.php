<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemService extends Model
{
    use HasFactory;

    protected $fillable = [
        'leaver_id',
        'leaver_code'
    ];
}
