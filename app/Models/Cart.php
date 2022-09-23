<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'carts';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'variant_id',
        'order_key',
        'quantity',
    ];

    public function order(){
        return $this->belongsTo(Order::class, 'order_key', 'order_key');
    }

    public function variant(){
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
}