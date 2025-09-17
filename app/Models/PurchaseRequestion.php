<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseRequestion extends Model
{
    use HasFactory;
    
    protected $fillable = [
        'purchase_requestion_number',
        'requestion',
        'employee_id',
        'date_of_request',
        'nm_barang',
        'qty',
        'supplier',
        'status',
        'status_code',
        'void',
        'approval_id',
        'process_date',
    ];
}
