<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\CategoryRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{


    public function __construct()
    {
        $this->authorizeResource(Category::class, 'category');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $can = [
            'create' => $request->user()->can('create', Category::class)
        ];

        $categories       = Category::all();
        $categories_data  = array();
        foreach ($categories as $ctg) {
            $categories_data[] = [
                'id' => $ctg->id,
                'name' => $ctg->name,
                'desc' => $ctg->desc,
                'total_products' => $ctg->products()->count() . ' Products'
            ];
        }

        return inertia('Dashboard/Category/Index', [
            'title' => appTitle(),
            'data' => $categories_data,
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
        return inertia('Dashboard/Category/Create', [
            'title' => appTitle(),
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryRequest $request)
    {
        $category            = new Category;
        $category->name      = $request->input('name');
        $category->desc      = $request->input('desc');
        $category->save();

        $msg = 'Failed to save '. $category->name;

        if ($category->save()){
            $msg = 'Successfully Create ' . $category->name;
        }

        return redirect()->route('category.index')->with('message', $msg);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        return inertia('Dashboard/Category/Edit', [
            'title' => appTitle(),
            'category' => $category,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $category->name      = $request->input('name');
        $category->desc      = $request->input('desc');
        $category->save();
        return redirect()->route('category.index')->with('message', 'Category ' . $category->name . ' updated');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        $category->products()->detach();
        $category->delete();
        return redirect()->route('category.index')->with('message', 'Category ' . $category->name . ' deleted');
    }

    /**
     * Remove the mass resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroyCategories(Request $request)
    {
        $categories = $request->input('categories');
        # delete the contact row by contact_id
        foreach ($categories as $pid) {
            $category = Category::find($pid);
            $category->products()->detach();
            $category->delete();
        }
        # redirect to index page of contact
        return redirect()->route('category.index')->with('message', count($categories) . ' Categories deleted');
    }
}