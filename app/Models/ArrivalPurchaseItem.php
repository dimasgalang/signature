<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArrivalPurchaseItem extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'arrival_number',
        'purchase_requestion_number',
        'date_of_arrival',
        'id_barang',
        'qty',
        'remarks',
    ];
}
