<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexRequest;
use App\Http\Resources\ApiResource;
use App\Models\Order;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;

class OrderController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(IndexRequest $request)
    {
        $validated = $request->safe()->only(['search']);

        $filters = [
            'search' => Arr::get($validated, 'search'),
            'page' => Arr::get($validated, 'page', 1),
        ];

        $orders          = Order::with('user');
        $orders          = $orders->when($filters['search'], function($query, $value){
            $query->where(function ($query) use ($value) {
                $query->where('order_key', 'like', '%' . $value . '%');
                $query->orWhereHas('user', function ($query) use ($value) {
                    $query->where(function($query) use ($value) {
                        $query->where('email', 'LIKE', '%' . $value . '%');
                    });
                });
            });
        })
        ->with(['user'])->orderBy('payment_status', 'asc')->paginate(10)->withQueryString();
        return inertia('Dashboard/Order/Index', [
            'title' => appTitle(),
            'data' => ApiResource::collection($orders),
            'filters' => $filters,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Order $order)
    {
        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Order $order, Transaction $transaction, User $user)
    {
        $order->carts;
        $order->shipping->destination;
        foreach($order->carts as $cart){
            $cart->variant->products->getMedia();
        }

        $data_customer = $user->where('id', $order->user_id)->first()->profile;
        $data_customer->user;
        $data_transaction = $transaction->where('order_key', $order->order_key)->first();
        
        return inertia('Dashboard/Order/Show', [
            'title' => appTitle(),
            'data' => [
                'order' => $order,
                'customer' => $data_customer,
                'transaction' => $data_transaction
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}