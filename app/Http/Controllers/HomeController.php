<?php

namespace App\Http\Controllers;

use App\Http\Requests\HomeFilterRequest;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;


class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
//    public function __construct()
//    {
//        $this->middleware('auth');
//    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function index(HomeFilterRequest $request)
    {
        $categories = Category::all();

        $productsQuery = Product::query();

        $bestProductIds = Order::get()->where('status', 3)->map->products->flatten()->map->pivot->mapTogroups(function ($pivot) {
            return [$pivot->product_article => $pivot->count];
        })->map->sum()->sortDesc()->take(3)->keys()->toArray();

        $bestProductIdsStr = implode(',', $bestProductIds);
        $bestProducts = Product::whereIn('article', $bestProductIds)
            ->orderByRaw(DB::raw("FIELD(article, $bestProductIdsStr)"))
            ->get();

        if ($request->filled('price_from')) {
            $productsQuery->where('price', '>=', $request->price_from);
        }
        if ($request->filled('price_to')) {
            $productsQuery->where('price', '<=', $request->price_to);
        }

        foreach (['new', 'hit', 'discount'] as $field) {
            if ($request->has($field)) {
                $productsQuery->where($field, 1);
            }
        }
        $products = $productsQuery->get();

        return view('welcome', compact('products', 'categories', 'bestProducts'));
    }


}
