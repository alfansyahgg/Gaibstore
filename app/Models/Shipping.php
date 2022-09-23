<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipping extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'shippings';
    public $incrementing = true;
    public $timestamps = true;

    protected $casts = [
        'shipping_costs' => 'int'
    ];

    protected $fillable = [
        'order_key',
        'first_name',
        'last_name',
        'phone_number',
        'country',
        'address',
        'city',
        'zip_code',
        'shipping_code',
        'shipping_name',
        'shipping_origin',
        'shipping_destination',
        'shipping_weight',
        'shipping_service',
        'shipping_cost',
        'shipping_etd',
    ];

    public function destination(){
        return $this->hasOne(City::class, 'city_id', 'shipping_destination');
    }
}