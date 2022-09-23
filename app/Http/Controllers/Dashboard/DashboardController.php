<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\IndexRequest;
use App\Http\Resources\ApiResource;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use App\Models\Variant;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index(IndexRequest $request){

        $products       = Product::all();
        $users          = User::all();
        $categories     = Category::all();
        $variants       = Variant::all();
        $orders         = Order::all();
        
        // $test = $orders->with(['user'])->get();
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

        // dd($order_table);

        return inertia('Dashboard/Index', [
            'title' => appTitle(),
            'data' => [
                'products' => [
                    'total' => $products->count()
                ],
                'categories' => [
                    'total' => $categories->count()
                ],
                'variants' => [
                    'total' => $variants->count()
                ],
                'orders' => [
                    'total' => $orders->count(),
                    'type' => [
                        'pending' => $orders->where('payment_status', 1)->count(),
                        'success' => $orders->where('payment_status', 2)->count(),
                        'expired' => $orders->where('payment_status', 3)->count(),
                        'canceled' => $orders->where('payment_status', 4)->count(),
                    ],
                    'data' => ApiResource::collection($orders),
                    'filters' => $filters,
                
                ],
                'users' => [
                    'total' => $users->count()
                ],
            ]
        ]);
    }
}