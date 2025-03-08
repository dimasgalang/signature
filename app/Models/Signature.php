<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Signature extends Model
{
    use HasFactory;
    public $table = "signatures";
    protected $fillable = [
        'user_id',
        'signature_img',
    ];
}
