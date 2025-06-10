<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Clearance extends Model
{
    use HasFactory;
    protected $fillable = [
        'document_name',
        'clearance_name_id',
        'receiver_name_id',
        'department',
        'date',
        'void',
    ];

    public function item_clearance()
    {
        return $this->hasMany(ItemClearance::class);
    }

    public function clearanceName()
    {
        return $this->belongsTo(User::class, 'clearance_name_id');
    }

    public function receiverName()
    {
        return $this->belongsTo(User::class, 'receiver_name_id');
    }
}
