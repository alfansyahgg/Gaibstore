<?php
 
namespace App\Services\Midtrans;
use Illuminate\Support\Facades\Auth;
use Midtrans\Snap;
 
class CreateSnapTokenService extends Midtrans
{
    protected $order;
 
    public function __construct($order)
    {
        parent::__construct();
 
        $this->order = $order;
    }
 
    public function getSnapToken()
    {
        $user = Auth::user();
        $profile = $user->profile;
        $shipping = $this->order->shipping;
        $codes = json_decode(file_get_contents('http://country.io/iso3.json'), true);
        // dd($shipping);

        $transaction_details = [
            'order_id' => $this->order->order_key,
            'gross_amount' => $this->order->total_price + intval($shipping->shipping_cost),
        ];

        // dd($transaction_details);

        $item_details = array();
        foreach($this->order->carts as $cart){
            array_push($item_details, [
                'id' => $cart->id,
                'price' => $cart->variant->products->price,
                'quantity' => $cart->quantity,
                'name' => $cart->variant->products->name,
            ]);
        }
        array_push($item_details, [
            'id' => rand(1000,9999),
            'price' => intval($shipping->shipping_cost),
            'quantity' => 1,
            'name' => $shipping->shipping_service . " - " . $shipping->shipping_name,
        ]);

        $billing_address = array(
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'address' => $profile->address,
            'city' => $profile->city,
            'postal_code' => $profile->zip_code,
            'phone' => $profile->phone_number,
            'country_code' => $codes[$profile->country]
        );

        $shipping_address = array(
            'first_name' => $shipping->first_name,
            'last_name' => $shipping->last_name,
            'address' => $shipping->address,
            'city' => $shipping->city,
            'postal_code' => $shipping->zip_code,
            'phone' => $shipping->phone_number,
            'country_code' => $codes[$shipping->country]
        );

        $customer_details = array(
            'first_name' => $profile->first_name,
            'last_name' => $profile->last_name,
            'email' => $user->email,
            'phone' => $profile->phone_number,
            'billing_address' => $billing_address,
            'shipping_address' => $shipping_address
        );

        $transaction = [
            'transaction_details' => $transaction_details,
            'customer_details' => $customer_details,
            'item_details' => $item_details,
        ];

        // $params = [
        //     'transaction_details' => [
        //         'order_id' => $this->order->order_key,
        //         'gross_amount' => $this->order->total_price,
        //     ],
        //     'item_details' => [
        //         [
        //             'id' => 1,
        //             'price' => '150000',
        //             'quantity' => 1,
        //             'name' => 'Flashdisk Toshiba 32GB',
        //         ],
        //         [
        //             'id' => 2,
        //             'price' => '60000',
        //             'quantity' => 2,
        //             'name' => 'Memory Card VGEN 4GB',
        //         ],
        //     ],
        //     'customer_details' => [
        //         'first_name' => 'Martin Mulyo Syahidin',
        //         'email' => 'mulyosyahidin95@gmail.com',
        //         'phone' => '081234567890',
        //     ]
        // ];
 
        $snapToken = Snap::getSnapToken($transaction);
 
        return $snapToken;
    }
}