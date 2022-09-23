<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Variant extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    protected $table = 'variants';
    protected $casts = [
        'product_id' => 'int',
        'price' => 'int',
    ];
    protected $fillable = [
        'product_id',
        'color',
        'size',
        'stock'
    ];
    public $timestamps = true;

    public function products(){
        return $this->belongsTo(Product::class, 'product_id');
    }
}