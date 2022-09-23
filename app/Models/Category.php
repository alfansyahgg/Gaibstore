<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $casts = [
        'name' => 'string',
        'desc' => 'string',
    ];

    protected $fillable = [
        'name',
        'desc'
    ];


    public function products()
    {
        return $this->belongsToMany(Product::class, 'category_product');
    }
}
