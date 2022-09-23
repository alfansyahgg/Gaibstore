<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileRequest;
use App\Http\Requests\User\IndexRequest;
use App\Models\City;
use App\Models\Order;
use App\Models\Profile;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Propaganistas\LaravelPhone\PhoneNumber;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request, City $city)
    {

        # get city
        $responseCity = $city->all();

        $profile = $request->user()->profile;
        $user_photo = $request->user()->getMedia('user_photo')->first();
        $profile->photo = $user_photo;
        $profile->photoPreview = $user_photo != null ? $user_photo->getUrl('thumb') : null;
        // dd($profile);

        return inertia('Profile/Index', [
            'title' => appTitle(),
            'data' => [
                'profile' => $profile,
                'city' => $responseCity
            ]
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Profile $profile, ProfileRequest $request)
    {
        $profile->first_name = $request->fname;
        $profile->last_name = $request->lname;
        $profile->address = $request->address;
        $profile->city_id = $request->city['id'];
        $profile->city = $request->city['name'];
        $profile->zip_code = $request->zip_code;
        $profile->phone_number = PhoneNumber::make($request->phone['number'], $request->phone['country'])->formatForMobileDialingInCountry($request->phone['country']);
        $profile->country = $request->phone['country'];
        $profile->update();
        
        if( $request->hasFile('photo') && $request->file('photo')->isValid() ){
            $profile->user->addMediaFromRequest('photo')->usingName(__generateString('us', Media::class, 'file_name', '7'))->toMediaCollection('user_photo');
        }

        return redirect()->back();
    }

    public function purchase(Request $request){

        $filters = [
            'search' => $request->input('search'),
        ];

        $profile = $request->user()->profile;

        $orders          = new Order;
        $orders          = $orders->where('user_id', $request->user()->id);
        $orders          = $orders->when($filters['search'], function($query, $value){
            $query->where(function ($query) use ($value) {
                $query->where('order_key', 'like', '%' . $value . '%');
            });
        })
        ->orderBy('created_at', 'desc')->get();
        foreach($orders as $order){
            $order->shipping;
            $order->carts;
            foreach($order->carts as $cart){
                $cart->variant->products->getMedia();
            }
        }

        // dd($orders);
        
        return inertia('Profile/Purchase', [
            'title' => appTitle(),
            'data' => [
                'profile' => $profile,
                'orders' => $orders
            ]
        ]);
    }

    public function account(Request $request){

        $account = $request->user();

        return inertia('Profile/Account', [
            'title' => appTitle(),
            'data' => [
                'account' => $account,
            ]
        ]);
    }

    public function updateAccount(Request $request,User $user){
        $request->validate([
            'password.old' => 'current_password|required',
            'password.new' => 'different:password.old|required|min:3|max:10',
            'password.confirm' => 'same:password.new|required',
        ]);

        $new_password = $request['password']['new'];
        $user->update([
            'password' => Hash::make($new_password)
        ]);
        return redirect()->route('profile.account')->with('success', 'Successfully update your password');
    }

    public function purchaseDetail(Request $request, Order $order, Transaction $transaction, User $user){
        
        $order->carts;
        $order->shipping->destination;
        foreach($order->carts as $cart){
            $cart->variant;
            $cart->variant->products->getMedia();
        }

        $data_customer = $user->where('id', $order->user_id)->first()->profile;
        $data_customer->user;
        $data_transaction = $transaction->where('order_key', $order->order_key)->first();
        
        return inertia('Profile/PurchaseDetail', [
            'title' => appTitle(),
            'data' => [
                'order' => $order,
                'customer' => $data_customer,
                'transaction' => $data_transaction
            ]
        ]);
    }
}