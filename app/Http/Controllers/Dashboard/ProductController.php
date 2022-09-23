<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Product::class, 'product');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $can = [
            'create' => $request->user()->can('create', Product::class)
        ];

        $products       = Product::all();
        $products_data  = array();
        foreach( $products as $prd ){
            $products_data[] = [
                'id' => $prd->id,
                'name' => $prd->name,
                'brand' => $prd->brand,
                'desc' => $prd->desc,
                'price' => 'Rp. '.number_format($prd->price, 0, '.', '.'),
                'categories' => $prd->categories,
                'variants' => $prd->variants()->count(),
                'photo' => $prd->getFirstMediaUrl('product_photos')
            ];
        }

        return inertia('Dashboard/Product/Index', [
            'title' => appTitle(),
            'data' => $products_data,
            'can' => $can,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        # get category
        $category = Category::all();

        return inertia('Dashboard/Product/Create', [
            'title' => appTitle(),
            'category' => $category
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $product            = new Product;
        $product->name      = $request->input('name');
        $product->desc      = $request->input('desc');
        $product->price     = $request->input('price');
        $product->save();
        $product->categories()->sync($request->input('category'));
        if($request->hasFile('photos')){
            foreach($request->file('photos') as $photo){
                if($photo->isValid()){
                    $product->addMedia($photo)->usingName(__generateString('pg', Media::class, 'file_name', '7'))->toMediaCollection('product_photos');
                }
            }
        }
        // variants
        $variants = $request->input('variant');
        $product->variants()->createMany($variants);

        return redirect()->route('product.index')->with('message', 'Successfully Create ' . $product->name);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        # get category
        $category = Category::all();

        # get product photos
        $photos = $product->getMedia('product_photos');
        $photo_list = array();
        foreach($photos as $pht){
            $photo_list[] = [
                'id' => $pht->name,
                'name' => $pht->file_name,
                'status' => 'finished',
                'url' => $pht->getUrl()
            ];
        }

        return inertia('Dashboard/Product/Edit', [
            'title' => appTitle(),
            'product' => $product,
            'variants' => $product->variants,
            'preview' => $photo_list,
            'category' => $category,
            'product_category' => $product->categories
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        $product->name      = $request->input('name');
        $product->brand      = $request->input('brand');
        $product->desc      = $request->input('desc');
        $product->price     = $request->input('price');
        $product->update();
        $product->categories()->sync($request->input('category'));
        if ($request->hasFile('photos')) {
            foreach ($request->file('photos') as $photo) {
                if ($photo->isValid()) {
                    $product->addMedia($photo)->usingName(__generateString('pg', Media::class, 'file_name', '7'))->toMediaCollection('product_photos');
                }
            }
        }
        // variants
        $variants = $request->input('variant');
        $product->variants()->delete();
        $product->variants()->createMany($variants);

        return redirect()->route('product.index')->with('message', 'Product ' . $product->name . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        $product->categories()->detach();
        $product->delete();
        return redirect()->route('product.index')->with('message', 'Product ' . $product->name . ' deleted');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Product  $product
     * @return \Illuminate\Http\Response
     */
    public function destroyProducts(Request $request)
    {
        $products = $request->input('products');
        # delete the contact row by contact_id
        foreach ($products as $pid) {
            $product = Product::find($pid);
            $product->categories()->detach();
            $product->delete();
        }
        # redirect to index page of contact
        return redirect()->route('product.index')->with('message', count($products) . ' Products deleted');
    }
}