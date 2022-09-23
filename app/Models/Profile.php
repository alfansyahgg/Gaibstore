<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Propaganistas\LaravelPhone\Casts\RawPhoneNumberCast;
use Propaganistas\LaravelPhone\Casts\E164PhoneNumberCast;

class Profile extends Model
{
    use HasFactory;
    protected $primaryKey = 'id';
    protected $keyType = 'int';
    public $incrementing = true;
    public $timestamps = true;

    protected $casts = [
        'first_name' => 'string',
        'last_name' => 'string',
        'phone.country'       => 'string',
        'phone.number'         => RawPhoneNumberCast::class. ':phone.country',
        'address' => 'string',
        'city' => 'string',
        'zip_code' => 'string',
    ];

    protected $fillable = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'city_id',
        'city',
        'country',
        'zip_code',
    ];

    protected $visible = [
        'user_id',
        'first_name',
        'last_name',
        'phone_number',
        'address',
        'city_id',
        'city',
        'country',
        'zip_code',
        'photo',
        'photoPreview'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}