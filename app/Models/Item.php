<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;
    protected $fillable = [
        'itemNumber',
        'productName',
        'qtyType',
    ];

    public function ItemHandover() {
        return $this->hasMany(ItemHandover::class);
    }
}
