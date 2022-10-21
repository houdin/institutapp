<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    /**
     * @var Product
     */
    protected $products;

    /**
     *
     */
    function __construct()
    {
    }

    /**
     * Displays a list of products to the user
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $products = Product::where('published', 1)
                ->with('image')
                ->with(['sales' => function ($query) {
                    return $query->current();
                }])
                ->orderBy('id', 'desc')
                ->paginate(9);
            // $products = $this->products->with(['sales' => function ($query) {
            //     return $query->current();
            // }])->paginate(9);
        } catch (\Exception $exception) {
            $exception->getMessage();
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'products' => $products
            ]);
        }

        // return view('frontend.products.shop', [
        //     'products' => $products
        // ]);
    }

    public function products()
    {
        try {
            $products = Product::where('published', 1)
                ->with('image')
                ->with(['sales' => function ($query) {
                    return $query->current();
                }])
                ->orderBy('id', 'desc')
                ->paginate(12);
        } catch (\Exception $exception) {
            $exception->getMessage();
        }

        $categories = Category::whereHas('products', function ($q) {
            $q->where('published', 1);
        })->get();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'products' => $products,
                'categories' => $categories
            ]);
        }
    }
}
