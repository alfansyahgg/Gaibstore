<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Auth;

class OrderRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'fname' => 'required|string',
            'lname' => 'required|string',
            'phone.number' => 'required',
            'phone.country' => 'required',
            'address' => 'required',
            'city.id' => 'required',
            'city.name' => 'required',
            'zip_code' => 'required',
            'total_price' => 'required|integer',
            'cart' => 'required|array',
            "origin" => 'required',
            "destination" => 'required',
            "weight" => 'required',
            'courier.code' => 'required',
            'courier.name' => 'sometimes',
            'courier.cost' => 'required',
            'courier.service' => 'required',
            'courier.etd' => 'sometimes',
        ];
    }
}