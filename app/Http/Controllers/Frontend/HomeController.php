<?php

namespace App\Http\Controllers\Frontend;

use Newsletter;
use App\Models\Faq;
use App\Models\Tag;
use App\Models\Blog;
use App\Models\Page;
use App\Models\Bundle;
use App\Models\Config;
use App\Models\Module;
use App\Models\Slider;
use App\Models\Premium;
use App\Models\Product;
use App\Models\Category;
use App\Models\Tutorial;
use App\Models\Auth\User;
use App\Models\Formation;
use App\Models\Portfolio;
use App\Models\Tipstrick;
use Illuminate\Http\Request;
use App\Models\System\Session;
use App\Models\FormationTimeline;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Response;
use Illuminate\Http\Response as HttpResponse;
use App\Http\Controllers\Frontend\FrontendBaseController;
use Inertia\Inertia;

/**
 * Class HomeController.
 */
class HomeController extends FrontendBaseController
{
    /**
     * @return \Illuminate\View\View
     */



    public function __construct()
    {
    }

    public function  index()
    {

        // if (request('page')) {
        //     $page = Page::where('slug', '=', request('page'))
        //     ->where('published', '=', 1)->first();
        //     if ($page != "") {
        //         return view('frontend.pages.index', compact('page'));
        //     }
        //     abort(404);
        // }

        $featured_formations = Formation::withoutGlobalScope('filter')->where('published', '=', 1)
            ->whereHas('category')
            ->where('featured', '=', 1)->take(8)->get();
        $tutorials = Tutorial::withoutGlobalScope('filter')->where('published', '=', 1)->take(2)->with('image')->orderBy('created_at', 'desc')->get();

        $formation_categories = Category::with('formations')->where('icon', '!=', "")->take(12)->get();

        $trending_formations = Formation::withoutGlobalScope('filter')
            ->whereHas('category')
            ->where('published', '=', 1)
            ->where('trending', '=', 1)->take(2)->get();

        $products = Product::take(2)->with('image')->orderBy('created_at', 'desc')->get();

        $news = Blog::orderBy('created_at', 'desc')->take(4)->with(['image'])->get();

        $portfolios = Portfolio::orderBy('created_at', 'desc')->take(6)->with('image')->get();

        $premiums = Premium::where('published', 1)->orderBy('price')->get();

        $snipet = Tipstrick::orderBy('created_at', 'desc')->first();


        $categories = Category::get();

        return Inertia::render("Home", [
            'featured_formations' =>  $featured_formations,
            'news' => $news,
            'products' => $products,
            'tutorials' => $tutorials,
            'premiums' => $premiums,
            'snipet' => $snipet,
            'portfolios' => $portfolios,
            'formation_categories' => $formation_categories,
            'categories' => $categories,


        ]);
    }

    public function appConf(Request $request)
    {
        return response()->json(['conf' => config($request->conf)]);
    }



    public function home_slides()
    {
        $slides = Slider::where('status', 1)->orderBy('sequence', 'asc')->get();

        return response()->json(['slides' => $slides]);
    }

    public function home_downloads()
    {
        # code...
    }

    public function home_product_head()
    {
        $product_head = Product::where('id', 4)->with('image')->first();

        return response()->json(['product' => $product_head]);
    }

    public function home_news()
    {
        $news = Blog::orderBy('created_at', 'desc')->take(4)->with(['image'])->get();

        return response()->json(['news' => $news]);
    }

    public function home_tutorials()
    {
        $tutorials = Tutorial::withoutGlobalScope('filter')->where('published', '=', 1)->take(2)->with('image')->orderBy('created_at', 'desc')->get();

        return response()->json(['tutorials' => $tutorials]);
    }

    public function home_products()
    {
        $products = Product::take(2)->with('image')->orderBy('created_at', 'desc')->get();

        return response()->json(['products' => $products]);
    }

    public function home_gallery()
    {
        $portfolios = Portfolio::orderBy('created_at', 'desc')->take(6)->with('image')->get();

        return response()->json(['portfolios' => $portfolios]);
    }

    public function home_snipet()
    {
        $snipet = Tipstrick::orderBy('created_at', 'desc')->first();

        return response()->json(['snipet' => $snipet]);
    }

    public function home_premium()
    {
        $premium = Premium::where('published', 1)->orderBy('price')->get();

        return response()->json(['premium' => $premium]);
    }

    public function home_faqs()
    {
        $faqs = Category::with('faqs')->get()->take(6);

        return response()->json(['faqs' => $faqs]);
    }

    public function getFaqs()
    {
        $faq_categories = Category::has('faqs', '>', 0)->get();
        return view('frontend.faq', compact('faq_categories'));
    }


    public function getTeachers()
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $teachers = User::role('teacher')->paginate(12);
        return view('frontend.teachers.index', compact('teachers', 'recent_news'));
    }

    public function showTeacher(Request $request)
    {
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $teacher = User::role('teacher')->where('id', '=', $request->id)->first();
        $formations = $teacher->formations;
        if (count($teacher->formations) > 0) {
            $formations = $teacher->formations()->paginate(12);
        }
        return view('frontend.teachers.show', compact('teacher', 'recent_news', 'formations'));
    }

    public function getDownload(Request $request)
    {
        if (auth()->check()) {
            $module = Module::findOrfail($request->module);
            $formation_id = $module->formation_id;
            $formation = Formation::findOrfail($formation_id);
            $purchased_formation = Auth::check() && $formation->students()->where('user_id', Auth::id())->count() > 0;
            if ($purchased_formation) {
                $file = public_path() . "/storage/uploads/" . $request->filename;

                return Response::download($file);
            }
            return abort(404);
        }
        return abort(404);
    }

    public function searchFormation(Request $request)
    {

        if (request('type') == 'popular') {
            $formations = Formation::withoutGlobalScope('filter')->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else if (request('type') == 'trending') {
            $formations = Formation::withoutGlobalScope('filter')->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else if (request('type') == 'featured') {
            $formations = Formation::withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else {
            $formations = Formation::withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(12);
        }


        if ($request->category != null) {
            $category = Category::find((int)$request->category);
            if ($category) {
                $ids = $category->formations->pluck('id')->toArray();
                $types = ['popular', 'trending', 'featured'];
                if ($category) {

                    if (in_array(request('type'), $types)) {
                        $type = request('type');
                        $formations = $category->formations()->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->q . '%');
                            $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                        })
                            ->whereIn('id', $ids)
                            ->where('published', '=', 1)
                            ->where($type, '=', 1)
                            ->paginate(12);
                    } else {
                        $formations = $category->formations()
                            ->where(function ($query) use ($request) {
                                $query->where('title', 'LIKE', '%' . $request->q . '%');
                                $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                            })
                            ->where('published', '=', 1)
                            ->whereIn('id', $ids)
                            ->paginate(12);
                    }
                }
            }
        } else {
            $formations = Formation::where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
                ->paginate(12);
        }

        $categories = Category::where('status', '=', 1)->get();


        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        return view('frontend.search-result.formations', compact('formations', 'q', 'recent_news', 'categories'));
    }


    public function searchBundle(Request $request)
    {

        if (request('type') == 'popular') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else if (request('type') == 'trending') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else if (request('type') == 'featured') {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(12);
        } else {
            $bundles = Bundle::withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(12);
        }


        if ($request->category != null) {
            $category = Category::find((int)$request->category);
            $ids = $category->bundles->pluck('id')->toArray();
            $types = ['popular', 'trending', 'featured'];
            if ($category) {

                if (in_array(request('type'), $types)) {
                    $type = request('type');
                    $bundles = $category->bundles()->where(function ($query) use ($request) {
                        $query->where('title', 'LIKE', '%' . $request->q . '%');
                        $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                    })
                        ->whereIn('id', $ids)
                        ->where('published', '=', 1)
                        ->where($type, '=', 1)
                        ->paginate(12);
                } else {
                    $bundles = $category->bundles()
                        ->where(function ($query) use ($request) {
                            $query->where('title', 'LIKE', '%' . $request->q . '%');
                            $query->orWhere('description', 'LIKE', '%' . $request->q . '%');
                        })
                        ->where('published', '=', 1)
                        ->whereIn('id', $ids)
                        ->paginate(12);
                }
            }
        } else {
            $bundles = Bundle::where('title', 'LIKE', '%' . $request->q . '%')
                ->orWhere('description', 'LIKE', '%' . $request->q . '%')
                ->where('published', '=', 1)
                ->paginate(12);
        }

        $categories = Category::where('status', '=', 1)->get();


        $q = $request->q;
        $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();

        return view('frontend.search-result.bundles', compact('bundles', 'q', 'recent_news', 'categories'));
    }

    public function searchBlog(Request $request)
    {
        $blogs = Blog::where('title', 'LIKE', '%' . $request->q . '%')
            ->paginate(12);
        $categories = Category::has('blogs')->where('status', '=', 1)->paginate(10);
        $popular_tags = Tag::has('blogs', '>', 4)->get();


        $q = $request->q;
        return view('frontend.search-result.blogs', compact('blogs', 'q', 'categories', 'popular_tags'));
    }
}
