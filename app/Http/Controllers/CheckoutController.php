<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Cart;
use App\Models\City;
use App\Models\Order;
use App\Models\Shipping;
use App\Models\Transaction;
use App\Services\Midtrans\CreateSnapTokenService;
use Illuminate\Http\Request;
use Propaganistas\LaravelPhone\PhoneNumber;

class CheckoutController extends Controller
{
    public function index(Request $request, City $city){

        # profile
        $profile = $request->user()->profile;

        # get city
        $responseCity = $city->all();

        # get data
        $cost = null;
        if($request->isMethod('post')){
            $data = $request->all();

            # raja ongkir get cost
            $cost = rajaOngkir('cost', 'post', [
                'origin' => 23,
                'destination' => $request->destination,
                'weight' => $request->weight,
                'courier' => $request->courier,
            ]);
        }


        return inertia('Checkout/Index', [
            'title' => appTitle(),
            'data' => [
                'city' => $responseCity,
                'profile' => $profile,
                'cost' => $cost
            ]
        ]);
    }

    public function cost(Request $request){

        # get data
        $data = $request->data;

        # raja ongkir get cost
        $cost = rajaOngkir('cost', 'post', [
            'origin' => 23,
            'destination' => $data['destination'],
            'weight' => $data['weight'],
            'courier' => $data['courier'],
        ]);

        return redirect()->route('checkout.index');

    }

    public function order(OrderRequest $request, Order $order,Shipping $shipping, Cart $cart){
        // dd($request->all());
        $gen_key = __generateString('ord', Order::class, 'order_key', 7);  
        $order_key = $gen_key; 
        $shipping->order_key        = $order_key;
        $shipping->first_name       = $request->fname;
        $shipping->last_name        = $request->lname;
        $shipping->address = $request->address;
        $shipping->city_id = $request->city['id'];
        $shipping->city = $request->city['name'];
        $shipping->zip_code         = $request->zip_code;
        $shipping->phone_number     = PhoneNumber::make($request->phone['number'], $request->phone['country'])->formatForMobileDialingInCountry($request->phone['country']);
        $shipping->country          = $request->phone['country'];
        $shipping->shipping_code        = $request->courier['code'];
        $shipping->shipping_name       = $request->courier['name'];
        $shipping->shipping_origin        = $request->origin;
        $shipping->shipping_destination     = $request->destination;
        $shipping->shipping_weight          = $request->weight;
        $shipping->shipping_service     = $request->courier['service'];
        $shipping->shipping_cost        = $request->courier['cost'];
        $shipping->shipping_etd         = $request->courier['etd'];
        $shipping->save();

        foreach($request->cart as $key => $item){
            $cart->create([
                'order_key' => $order_key,
                'user_id' => $request->user()->id,
                'variant_id' => $item['id'],
                'quantity' => $item['quantity']
            ]);
        }

        $order->order_key       = $order_key;
        $order->user_id         = $request->user()->id;
        $order->total_price     = $request->total_price;
        $order->payment_status  = '1';
        $order->shipping_id     = $shipping->id;

        # midtrans token
        $midtrans = new CreateSnapTokenService($order);
        $snapToken = $midtrans->getSnapToken();
        $order->snap_token = $snapToken;
        $order->save();

        session()->forget('cart');

        return redirect()->route('profile.purchase')->with('success', 'Your order is created');
    }

    public function removeOrder(Order $order){
        $order->carts()->delete();
        $order->shipping()->delete();
        $order->delete();
        return redirect()->route('profile.purchase')->with('success', 'Your order is removed');
    }

    public function transaction(Request $request, Transaction $transaction){

    }
}