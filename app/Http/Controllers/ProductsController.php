<?php

namespace App\Http\Controllers;


use App\Models\Category;
use App\Library\Format\DateFormat;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
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
    /**
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show($slug)
    {
        $product =  Product::where('slug', $slug)->firstOrFail();

        $product_rating = 0;
        $total_ratings = 0;

        $is_reviewed = false;
        if (auth()->check() && $product->reviews()->where('user_id', '=', auth()->user()->id)->first()) {
            $is_reviewed = true;
        }
        if ($product->reviews->count() > 0) {
            $product_rating = $product->reviews->avg('rating');
            $total_ratings = $product->reviews()->where('rating', '!=', "")->get()->count();
        }

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'product' => $product,
                'product_rating' => $product_rating,
                'total_ratings' => $total_ratings
            ]);
        }



        return view('frontend.products.show', compact('product', 'product_rating', 'total_ratings'));
    }
}
