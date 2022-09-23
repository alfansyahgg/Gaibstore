<?php

namespace App\Http\Controllers;

use App\Http\Requests\ShopSearchRequest;
use App\Models\City;
use App\Models\Product;
use App\Models\Variant;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request as Psr7Request;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Http;
use Inertia\Inertia;

class WelcomeController extends Controller
{
    public function index(){
        $products   = Product::all()->take(3);
        foreach($products as $key => $prd){
            $prd->getMedia('product_photos')->first()->getUrl();
        }

        return inertia('Welcome/Index', [
            'title' => 'Best Place to Shop',
            'product_item' => $products
        ]);
    }

    public function about(){
        return inertia('Welcome/About', [
            'title' => 'Best Place to Shop'
        ]);
    }

    public function contact()
    {
        return inertia('Welcome/Contact', [
            'title' => 'Best Place to Shop'
        ]);
    }

    public function shop(ShopSearchRequest $request)
    {
        $validated = $request->safe()->only(['search', 'category']);

        $filters = [
            'search' => Arr::get($validated, 'search'),
            'category' => Arr::get($validated, 'category'),
        ];

        $products          = new Product;
        $products          = $products->when($filters['search'], function($query, $value){
            $query->where(function ($query) use ($value) {
                $query->where('name', 'like', '%' . $value . '%');
            });
        })
        ->orderBy('name', 'asc')->paginate(12);
        $products->links();
        foreach($products as $key => $prd){
            $prd->getMedia('product_photos')->first()->getUrl();
        }
        return inertia('Welcome/Shop', [
            'title' => 'Best Place to Shop',
            'shop_item' => $products
        ]);
    }

    public function detail(Product $product){
        # random products
        $products   = Product::all()->take(3);
        $product_item       = array();
        foreach($products as $key => $prd){
            $product_item[$key]['id'] = $prd->id;
            $product_item[$key]['image'] = $prd->getMedia('product_photos')->first()->getUrl();
            $product_item[$key]['label'] = $prd->name;
            $product_item[$key]['desc'] = $prd->desc;
            $product_item[$key]['price'] = $prd->price;
            $product_item[$key]['rate'] = rand(3, 5);
        }

        # get media
        $product->getMedia('product_photos');
        # get variants
        $product->variants;
        return inertia('Welcome/Detail', [
            'title' => 'Best Place to Shop',
            'data' => [
                'product' => $product,
            ],
            'product_item' => $product_item
        ]);
    }

    public function checkout(City $city){

        $responseCity = $city->all();
        return inertia('Welcome/Checkout', [
            'title' => appTitle(),
            'data' => [
                'city' => $responseCity
            ]
        ]);
    }

    public function addToCart(Request $request){
        $item = $request->input('data');
        $variant = Variant::find($item['id']);
        $item = [
            ...$item,
            ...$variant->products->only(['name', 'brand', 'price', 'desc', ]),
            ...[
                'preview' => $variant->products->getMedia('product_photos')[0]->getUrl('preview')
            ]
        ];
        $cart_arr = session('cart');
        $cart_arr[$item['id']] = $item; 
        session(['cart' => $cart_arr]);
        return redirect()->back();
    }

    public function deleteFromCart(Request $request){
        $variant_id = $request->input('data');
        $cart_arr = session('cart');
        unset($cart_arr[$variant_id]);
        session(['cart' => $cart_arr]);
        return redirect()->back();
    }
}