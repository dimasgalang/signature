<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Leaver extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_name',
        'leaver_name_id',
        'receiver_name_id',
        'department',
        'date',
        'void',
    ];

    public function item_leaver()
    {
        return $this->hasMany(ItemLeaver::class);
    }

    public function leaverName()
    {
        return $this->belongsTo(User::class, 'leaver_name_id');
    }

    public function receiverName()
    {
        return $this->belongsTo(User::class, 'receiver_name_id');
    }
}
