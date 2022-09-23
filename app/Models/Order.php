<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'orders';
    public $incrementing = true;
    public $timestamps = true;

    protected $casts = [
        'order_key' => 'string',
        'total_price' => 'int',
    ];

    protected $fillable = [
        'order_key',
        'user_id',
        'shipping_id',
        'total_price',
        'payment_status',
        'snap_token',
    ];


    public function carts(){
        return $this->hasMany(Cart::class, 'order_key', 'order_key');
    }

    public function shipping(){
        return $this->hasOne(Shipping::class, 'id', 'shipping_id');
    }
    
    public function user(){
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}