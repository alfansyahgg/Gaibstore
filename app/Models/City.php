<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class City extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'city';
    public $incrementing = true;
    public $timestamps = true;

    protected $fillable = [
        'city_id',
        'province_id',
        'province',
        'type',
        'postal_code',
        'city_name',
    ];
}