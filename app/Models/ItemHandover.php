<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemHandover extends Model
{
    use HasFactory;
    protected $fillable = [
        'handover_id',
        'item_id',
        'quantity',
    ];

    public function item()
    {
        return $this->belongsTo(Item::class);
    }

    public function handover()
    {
        return $this->belongsTo(Handover::class);
    }
}
