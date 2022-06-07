<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ProductFilterRequest;
use App\Http\Requests\ProductRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ProductFilterRequest $request)
    {



        $bestProductIds = Order::get()->where('status', 3)->map->products->flatten()->map->pivot->mapTogroups(function ($pivot) {
            return [$pivot->product_article => $pivot->count];
        })->map->sum()->sortDesc()->take(3)->keys()->toArray();

        $bestProductIdsStr = implode(',', $bestProductIds);
        $bestProducts = Product::whereIn('article', $bestProductIds)
            ->orderByRaw(DB::raw("FIELD(article, $bestProductIdsStr)"))
            ->get();



        $categories = Category::all();
        $productsQuery = Product::query();


        if ($request->filled('price_from')) {
            $productsQuery->where('price', '>=', $request->price_from);
        }

        if ($request->filled('price_to')) {
            $productsQuery->where('price', '<=', $request->price_to);
        }

        if ($request->filled('category')) {
            $productsQuery->where('category_article', '=', $request->category);
        }

        if ($request->filled('search')) {
            $productsQuery->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->category_trashed == 1) {
            $products = $productsQuery->onlyTrashed()->with('category')->Paginate(5)->withPath($request->getUri());
        } else if ($request->category_trashed == 2) {
            $products = $productsQuery->withTrashed()->with('category')->Paginate(5)->withPath($request->getUri());
        } else {
            $products = $productsQuery->with('category')->Paginate(5)->withPath($request->getUri());
        }

        return view('auth.products.index', compact('products', 'categories', 'bestProducts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        return view('auth.products.form', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        $params = $request->all();
        unset($params['img']);
        if ($request->has('img')) {
            $params['img'] = $request->file('img')->store('products');
        }

        foreach (['new', 'hit', 'discount'] as $fieldName) {
            if (!isset($params[$fieldName])) {
                $params[$fieldName] = 0;
            }
        }

        Product::create($params);

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        return view('auth.products.show', compact('product'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $categories = Category::get();

        return view('auth.products.form', compact('product', 'categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(ProductRequest $request, Product $product)
    {
        $params = $request->all();

        unset($params['img']);
        if ($request->has('img')) {
            Storage::delete($product->image);
            $params['img'] = $request->file('img')->store('products');
        }

        foreach (['new', 'hit', 'discount'] as $fieldName) {
            if (!isset($params[$fieldName])) {
                $params[$fieldName] = 0;
            }
        }

        $product->update($params);
        return redirect()->route('products.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Product $product
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return back();
    }

    public function restore($id)
    {
        $product = Product::onlyTrashed()->findOrFail($id);
        $product->restore();
        return back();
    }
}
