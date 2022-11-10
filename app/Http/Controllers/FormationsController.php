<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Bundle;
use App\Models\Category;
use App\Models\Formation;
use App\Models\Review;
use Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;
use Stripe\Stripe;
use Stripe\Charge;
use Stripe\Customer;

class FormationsController extends Controller
{

    private $path;

    public function __construct()
    {
    }

    public function index(Request $request)
    {

        if (request('type') == 'popular') {
            $formations = Formation::withoutGlobalScope('filter')
                ->when($request->input('s'), function ($query, $s) {
                    $query->where("title", 'like', "%{$s}%");
                })
                ->where('published', 1)
                ->where('popular', '=', 1)
                ->with('image')
                ->orderBy('id', 'desc')
                ->paginate(9)
                ->withQueryString();
        } else if (request('type') == 'trending') {
            $formations = Formation::withoutGlobalScope('filter')
                ->when($request->input('s'), function ($query, $s) {
                    $query->where("title", 'like', "%{$s}%");
                })
                ->where('published', 1)
                ->where('trending', '=', 1)
                ->with('image')
                ->orderBy('id', 'desc')
                ->paginate(9)
                ->withQueryString();
        } else if (request('type') == 'featured') {
            $formations = Formation::withoutGlobalScope('filter')
                ->when($request->input('s'), function ($query, $s) {
                    $query->where("title", 'like', "%{$s}%");
                })
                ->where('published', 1)
                ->where('featured', '=', 1)
                ->with('image')
                ->orderBy('id', 'desc')
                ->paginate(9)
                ->withQueryString();
        } else {
            $formations = Formation::withoutGlobalScope('filter')
                ->when($request->input('s'), function ($query, $s) {
                    $query->where("title", 'like', "%{$s}%");
                })
                ->where('published', 1)
                ->with('image')
                ->orderBy('id', 'desc')
                ->paginate(9)
                ->withQueryString();
        }
        $purchased_formations = NULL;
        $purchased_bundles = NULL;
        // $categories = Category::where('status', '=', 1)->get();

        $categories = Category::whereHas('formations', function ($q) {
            $q->where('published', 1);
        })->get();


        // dd($categories);

        if (\Auth::check()) {
            $purchased_formations = Formation::withoutGlobalScope('filter')->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('modules')
                ->with('image')
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_formations = Formation::withoutGlobalScope('filter')->where('published', '=', 1)
            ->with('image')
            ->where('featured', '=', 1)->take(8)->get();

        $recent_news = Blog::orderBy('created_at', 'desc')
            ->with('image')
            ->take(2)
            ->get();

        return Inertia::render('Ressources/Formations/FormationsIndex', [
            'formations' => $formations,
            'purchased_formations' => $purchased_formations,
            'recent_news' => $recent_news,
            'featured_formations' => $featured_formations,
            'categories' => $categories,
            'filters' => $request->only(['s'])
        ]);
        //     [
        //     'users' => User::query()
        //         ->when($request->input('search'), function ($query, $search) {
        //             $query->whereRaw("concat(first_name,' ',last_name) like '%{$search}%'");
        //         })
        //         ->paginate(10)
        //         ->withQueryString()
        //         ->through(fn ($user) => [
        //             'id' => $user->id,
        //             'name' => $user->name,
        //         ]),

        // ])
    }

    public function show($formation_slug)
    {
        $continue_formation = NULL;
        //$recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $formation = Formation::withoutGlobalScope('filter')
            ->where('slug', $formation_slug)
            // ->withCount(['bundles.formations', 'bundles.students'])
            ->with([
                'publishedModules',
                'image',
                'reviews',
                'students:active',
                'mediaVideo',
                'category',

            ])
            ->firstOrFail();

        // dd($formation);
        // $bundles = Formation::withoutGlobalScope('filter')
        //     ->where('slug', $formation_slug)->with('bundles')->get()->pluck('bundles')->toArray()[0];
        // $bundles = Bundle::whereIn('id', $formation->bundles->pluck('id')->toArray())
        //     ->withCount(['formations', 'students'])
        //     ->with(['image:name,slug'])
        //     ->get();
        // dd($bundles);


        $purchased_formation = \Auth::check() && $formation->students()->where('user_id', \Auth::id())->count() > 0;
        if (($formation->published == 0) && ($purchased_formation == false)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([], 404);
            }
            abort(404);
        }
        $formation_rating = 0;
        $total_ratings = 0;
        $completed_modules = "";
        $is_reviewed = false;
        if (auth()->check() && $formation->reviews()->where('user_id', '=', auth()->user()->id)->first()) {
            $is_reviewed = true;
        }
        // if ($formation->reviews->count() > 0) {
        //     $formation_rating = $formation->reviews->avg('rating');
        //     $total_ratings = $formation->reviews()->where('rating', '!=', "")->get()->count();
        // }
        $modules = $formation->formationTimeline()->with('model')->orderby('sequence', 'asc')->get();
        if (\Auth::check()) {

            $completed_modules = \Auth::user()->chapters()->where('formation_id', $formation->id)->get()->pluck('model_id')->toArray();
            $formation_modules = $formation->modules->pluck('id')->toArray();
            $continue_formation  = $formation->formationTimeline()
                ->with('model')
                ->whereIn('model_id', $formation_modules)
                ->orderby('sequence', 'asc')
                ->whereNotIn('model_id', $completed_modules)
                ->first();

            if ($continue_formation == null) {
                $continue_formation = $formation->formationTimeline()
                    ->whereIn('model_id', $formation_modules)

                    ->orderby('sequence', 'asc')->first();
            }
        }

        return Inertia::render('Ressources/Formations/FormationShow', [
            'formation' => $formation,
            'purchased_formation' => $purchased_formation,
            'formation_rating' => $formation_rating,
            'completed_modules' => $completed_modules,
            'total_ratings' => $total_ratings,
            'is_reviewed' => $is_reviewed,
            'modules' => $modules,
            'continue_formation' => $continue_formation
        ]);
    }

    public function isPurchased($formation_id)
    {

        $formation = Formation::where('id', $formation_id)
            ->firstOrFail();

        $purchased_formation = \Auth::check() && $formation->students()->where('user_id', \Auth::id())->count() > 0;
        if (($formation->published == 0) && ($purchased_formation == false)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([], 404);
            }
            abort(404);
        }
        if (($formation->published == 1) && ($purchased_formation == true)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'purchased' => true
                ]);
            }
            abort(404);
        }
    }


    public function rating($formation_id, Request $request)
    {
        $formation = Formation::findOrFail($formation_id);
        $formation->students()->updateExistingPivot(\Auth::id(), ['rating' => $request->get('rating')]);

        return redirect()->back()->with('success', 'Thank you for rating.');
    }

    public function getByCategory(Request $request)
    {
        $category = Category::where('slug', '=', $request->category)
            ->where('status', '=', 1)
            ->first();
        $categories = Category::where('status', '=', 1)->get();

        if ($category != "") {
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $featured_formations = Formation::where('published', '=', 1)
                ->where('featured', '=', 1)->take(8)->get();

            if (request('type') == 'popular') {
                $formations = $category->formations()->withoutGlobalScope('filter')->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else if (request('type') == 'trending') {
                $formations = $category->formations()->withoutGlobalScope('filter')->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else if (request('type') == 'featured') {
                $formations = $category->formations()->withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else {
                $formations = $category->formations()->withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(9);
            }
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'formations' => $formations,
                    'category' => $category,
                    'categories' => $categories
                ]);
            }

            return view('frontend.formations.index', compact('formations', 'category', 'categories'));
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        return abort(404);
    }

    public function addReview(Request $request)
    {
        $this->validate($request, [
            'review' => 'required'
        ]);
        $formation = Formation::findORFail($request->id);
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->reviewable_id = $formation->id;
        $review->reviewable_type = Formation::class;
        $review->rating = $request->rating;
        $review->content = $request->review;
        $review->save();
        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'success' => true,
                'redirect' => 'back'
            ]);
        }
        return back();
    }

    public function editReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $formation = $review->reviewable;
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $purchased_formation = \Auth::check() && $formation->students()->where('user_id', \Auth::id())->count() > 0;
            $formation_rating = 0;
            $total_ratings = 0;
            $modules = $formation->formationTimeline()->orderby('sequence', 'asc')->get();

            if ($formation->reviews->count() > 0) {
                $formation_rating = $formation->reviews->avg('rating');
                $total_ratings = $formation->reviews()->where('rating', '!=', "")->get()->count();
            }
            if (\Auth::check()) {

                $completed_modules = \Auth::user()->chapters()->where('formation_id', $formation->id)->get()->pluck('model_id')->toArray();
                $continue_formation  = $formation->formationTimeline()->orderby('sequence', 'asc')->whereNotIn('model_id', $completed_modules)->first();
                if ($continue_formation == "") {
                    $continue_formation = $formation->formationTimeline()->orderby('sequence', 'asc')->first();
                }
            }
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'formation' => $formation,
                    'purchased_formation' => $purchased_formation,
                    'recent_news' => $recent_news,
                    'formation_rating' => $formation_rating,
                    'completed_modules' => $completed_modules,
                    'total_ratings' => $total_ratings,
                    'review' => $review,
                    'modules' => $modules,
                    'continue_formation' => $continue_formation
                ]);
            }
            return view('frontend.formations.formation', compact('formation', 'purchased_formation', 'recent_news', 'completed_modules', 'continue_formation', 'formation_rating', 'total_ratings', 'modules', 'review'));
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        return abort(404);
    }


    public function updateReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $review->rating = $request->rating;
            $review->content = $request->review;
            $review->save();

            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('formations.show', ['slug' => $review->reviewable->slug])
                ]);
            }

            return redirect()->route('formations.show', ['slug' => $review->reviewable->slug]);
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        return abort(404);
    }

    public function deleteReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $slug = $review->reviewable->slug;
            $review->delete();
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'success' => true,
                    'redirect' => route('formations.show', ['slug' => $slug])
                ]);
            }
            return redirect()->route('formations.show', ['slug' => $slug]);
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        return abort(404);
    }
    public function getCartSessionElem($id)
    {

        if (auth()->check() && (request()->ajax() || request()->api == true)) {
            return response()->json([
                'cart_elem' => Cart::session(\Auth::user()->id)->get($id),

            ]);
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        // return Cart::session(\Auth::user()->id)->get($request->formation_id);

        return abort(404);
    }
}
