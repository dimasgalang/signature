<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Handover extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_name',
        'handover_name_id',
        'receiver_name_id',
        'department',
        'date',
        'void',
    ];

    public function item_handovers()
    {
        return $this->hasMany(ItemHandover::class);
    }

    public function handoverName()
    {
        return $this->belongsTo(User::class, 'handover_name_id');
    }

    public function receiverName()
    {
        return $this->belongsTo(User::class, 'receiver_name_id');
    }
}
