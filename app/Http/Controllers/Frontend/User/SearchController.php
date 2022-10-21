<?php

namespace App\Http\Controllers\Frontend\User;


use App\Models\Category;
use App\Models\Product;
use App\Http\Controllers\Frontend\FrontendBaseController;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class SearchController extends UserPagesController
{
    /**
     * returns a view products page with products from the
     *
     * @param string $name
     * @param Category $categories
     * @param Product $product
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function category($name, Category $categories, Product $product)
    {
        $query = $categories
            ->where('name', $name)
            ->first()
            ->products()
            ->paginate(9);

        return view('frontend.products.search', [
            'products' => $query,
            'search' => $name
        ]);
    }

    /**
     * validates the search request and returns the redirects to the show method
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function scout(Request $request)
    {
        $this->validate($request, [
            'search' => 'required|basic_characters'
        ]);
        return redirect()->to('boutique/produits/' . $request->search);
    }

    /**
     * returns the users search results
     *
     * @param Product $product
     * @param $search
     * @return \Illuminate\Contracts\View\Factory|RedirectResponse|\Illuminate\View\View
     */
    public function show(Product $product, $search)
    {
        if (!preg_match('/^[\pL1-9\s.\',?]+$/u', $search)) {
            return $this->hasError('The search may only contain letters, numbers, punctuation, and spaces.');
        }

        return view('frontend.products.search', [
            'products' => $product->search($search)->paginate(9),
            'search' => $search
        ]);
    }
}
