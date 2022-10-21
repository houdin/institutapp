<?php

namespace App\Http\Controllers\Frontend\User\API;


use App\Models\Product;
use App\Models\Category;
use App\Models\Supplier;
use App\Models\Tutorial;
use App\Models\Formation;
use App\Models\Portfolio;
use App\Models\Tipstrick;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\FrontendBaseController;
use App\Library\Transformer\ProductsTransformer;

class SearchController extends FrontendBaseController
{
    /**
     * returns the users search results
     *
     * @param Request $request
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function store(Request $request, Product $product, Formation $formation, Tutorial $tutorial, Portfolio $portfolio)
    {
        $this->validate($request, [
            'search' => 'required|basic_characters'
        ]);
        $products = $product->search($request->search)->get()->take(7);
        $formations = $formation->search($request->search)->get()->take(7);
        $tutorials = $tutorial->search($request->search)->get()->take(7);
        $portfolios = $portfolio->search($request->search)->get()->take(7);
        // $tipstricks = $tipstrick->search($request->search)->get();
        $array = [];
        if ($products) {
            $products = $products->map(function ($prod) {
                $prod->type = 'product';
                $prod->image_id = asset('storage/uploads/pdts/' . $prod->image->name);
                $prod->vendor_id = Supplier::where('id', $prod->vendor_id)->get()->pluck('company')[0];
                $prod->category_id = Category::where('id', $prod->category_id)->get()->pluck('name')[0];
                return collect($prod->toArray())
                    ->only(['id', 'title', 'description', 'image_id', 'category_id', 'vendor_id', 'type', 'slug'])
                    ->all();
            });
            foreach ($products as $item) {
                $item['req'] = $request->search;
                $array[] = $item;
            }
        }
        if ($formations) {
            $formations = $formations->map(function ($form) {
                $form->type = 'formation';
                $form->category_id = Category::where('id', $form->category_id)->get()->pluck('name')[0];
                return collect($form->toArray())
                    ->only(['id', 'title', 'description', 'category_id', 'type', 'slug'],)
                    ->all();
            });
            foreach ($formations as $item) {
                $item['req'] = $request->search;
                $array[] = $item;
            }
        }
        if ($tutorials) {
            $tutorials = $tutorials->map(function ($tuto) {
                $tuto->type = 'tutorial';
                $tuto->category_id = Category::where('id', $tuto->category_id)->get()->pluck('name')[0];
                return collect($tuto->toArray())
                    ->only(['id', 'title', 'description', 'category_id', 'type', 'slug'])
                    ->all();
            });
            foreach ($tutorials as $item) {
                $item['req'] = $request->search;
                $array[] = $item;
            }
        }
        if ($portfolios) {
            $portfolios = $portfolios->map(function ($porto) {
                $porto->type = 'portfolio';
                $porto->category_id = Category::where('id', $porto->category_id)->get()->pluck('name')[0];
                return collect($porto->toArray())
                    ->only(['id', 'title', 'description', 'category_id', 'type', 'slug'])
                    ->all();
            });
            foreach ($portfolios as $item) {
                $item['req'] = $request->search;
                $array[] = $item;
            }
        }
        // $array['req'] = $request->search;

        $array = collect($array)->sortBy(function ($value, $key) {
            return strripos(Str::lower($value['title']), Str::lower($value['req']), 0);
        }, SORT_REGULAR)->reverse()->toArray();

        $array = array_slice($array, 0, 7);
        // dd($array);

        return response()->json(
            [
                // 'products' => ProductsTransformer::transform($array),
                'products' => $array,
                'search' => $request->search
            ],
            200
        );
    }
}
