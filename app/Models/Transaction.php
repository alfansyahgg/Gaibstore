<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'transactions';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'order_key',
        'payment_type',
        'total_price',
        'status',
        'bank',
        'va_number',
        'fraud_status',
        'bca_va_number',
        'permata_va_number',
        'pdf_url',
        'bill_key',
        'biller_code',
        'payment_code',
        'status_code',
        'transaction_id',
        'transaction_status',
        'transaction_time',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_key', 'order_key');
    }
}