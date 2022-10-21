<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Review;
use App\Models\Category;
use App\Models\Tutorial;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TutorialsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }


    public function all()
    {

        $tutorials = Tutorial::withoutGlobalScope('filter')
            ->where('published', 1)
            ->with('category')
            ->with('image')
            ->orderBy('created_at', 'desc')
            ->paginate(12);

        $purchased_tutorials = NULL;

        $categories = Category::where('status', '=', 1)->get();

        if (Auth::check()) {
            $purchased_tutorials = Tutorial::withoutGlobalScope('filter')->whereHas('students', function ($query) {
                $query->where('id', Auth::id());
            })
                ->orderBy('id', 'desc')
                ->get();
        }
        $featured_tutorials = Tutorial::withoutGlobalScope('filter')->where('published', '=', 1)
            ->where('featured', '=', 1)->take(8)->get();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'tutorials' => $tutorials,
                'purchased_tutorials' => $purchased_tutorials,
                'featured_tutorials' => $featured_tutorials,
                'categories' => $categories
            ]);
        }

        return view('frontend.tutorials.index', compact('tutorials', 'purchased_tutorials', 'categories'));
    }

    public function show($tutorial_slug)
    {
        $continue_tutorial = NULL;
        // $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
        $tutorial = Tutorial::withoutGlobalScope('filter')
            ->with([
                'image', 'mediaVideo',
                'category'
            ])
            ->where('slug', $tutorial_slug)
            ->firstOrFail();
        $purchased_tutorial = Auth::check() && $tutorial->students()->where('user_id', Auth::id())->count() > 0;
        if (($tutorial->published == 0) && ($purchased_tutorial == false)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([], 404);
            }
            abort(404);
        }
        $tutorial_rating = 0;
        $total_ratings = 0;

        $is_reviewed = false;
        if (auth()->check() && $tutorial->reviews()->where('user_id', '=', auth()->user()->id)->first()) {
            $is_reviewed = true;
        }
        if ($tutorial->reviews->count() > 0) {
            $tutorial_rating = $tutorial->reviews->avg('rating');
            $total_ratings = $tutorial->reviews()->where('rating', '!=', "")->get()->count();
        }


        if (Auth::check()) {
        }

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'tutorial' => $tutorial,
                'purchased_tutorial' => $purchased_tutorial,
                'tutorial_rating' => $tutorial_rating,
                'total_ratings' => $total_ratings,
                'is_reviewed' => $is_reviewed

            ]);
        }

        // return view('frontend.tutorials.tutorial', compact('tutorial', 'purchased_tutorial', 'recent_news', 'tutorial_rating', 'total_ratings', 'is_reviewed'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tutorial  $tutorial
     * @return \Illuminate\Http\Response
     */
    public function edit(Tutorial $tutorial)
    {
        //
    }


    public function rating($tutorial_id, Request $request)
    {
        $tutorial = Tutorial::findOrFail($tutorial_id);
        $tutorial->students()->updateExistingPivot(\Auth::id(), ['rating' => $request->get('rating')]);

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
            $featured_tutorials = Tutorial::where('published', '=', 1)
                ->where('featured', '=', 1)->take(8)->get();

            if (request('type') == 'popular') {
                $tutorials = $category->tutorials()->withoutGlobalScope('filter')->where('published', 1)->where('popular', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else if (request('type') == 'trending') {
                $tutorials = $category->tutorials()->withoutGlobalScope('filter')->where('published', 1)->where('trending', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else if (request('type') == 'featured') {
                $tutorials = $category->tutorials()->withoutGlobalScope('filter')->where('published', 1)->where('featured', '=', 1)->orderBy('id', 'desc')->paginate(9);
            } else {
                $tutorials = $category->tutorials()->withoutGlobalScope('filter')->where('published', 1)->orderBy('id', 'desc')->paginate(9);
            }


            return view('frontend.tutorials.index', compact('tutorials', 'category', 'recent_news', 'featured_tutorials', 'categories'));
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
        $tutorial = Tutorial::findORFail($request->id);
        $review = new Review();
        $review->user_id = auth()->user()->id;
        $review->reviewable_id = $tutorial->id;
        $review->reviewable_type = Tutorial::class;
        $review->rating = $request->rating;
        $review->content = $request->review;
        $review->save();

        return back();
    }

    public function editReview(Request $request)
    {
        $review = Review::where('id', '=', $request->id)->where('user_id', '=', auth()->user()->id)->first();
        if ($review) {
            $tutorial = $review->reviewable;
            $recent_news = Blog::orderBy('created_at', 'desc')->take(2)->get();
            $purchased_tutorial = Auth::check() && $tutorial->students()->where('user_id', \Auth::id())->count() > 0;
            $tutorial_rating = 0;
            $total_ratings = 0;
            $modules = $tutorial->tutorialTimeline()->orderby('sequence', 'asc')->get();

            if ($tutorial->reviews->count() > 0) {
                $tutorial_rating = $tutorial->reviews->avg('rating');
                $total_ratings = $tutorial->reviews()->where('rating', '!=', "")->get()->count();
            }
            if (Auth::check()) {

                $completed_modules = Auth::user()->chapters()->where('tutorial_id', $tutorial->id)->get()->pluck('model_id')->toArray();
                $continue_tutorial  = $tutorial->tutorialTimeline()->orderby('sequence', 'asc')->whereNotIn('model_id', $completed_modules)->first();
                if ($continue_tutorial == "") {
                    $continue_tutorial = $tutorial->tutorialTimeline()->orderby('sequence', 'asc')->first();
                }
            }
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'tutorial' => $tutorial,
                    'purchased_tutorial' => $purchased_tutorial,
                    'recent_news' => $recent_news,
                    'tutorial_rating' => $tutorial_rating,
                    'total_ratings' => $total_ratings,
                    'review' => $review,
                    'continue_tutorial' => $continue_tutorial
                ]);
            }
            return view('frontend.tutorials.tutorial', compact('tutorial', 'purchased_tutorial', 'recent_news',  'continue_tutorial', 'tutorial_rating', 'total_ratings', 'review'));
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

            return redirect()->route('tutorials.show', ['slug' => $review->reviewable->slug]);
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
            return redirect()->route('tutorials.show', ['slug' => $slug]);
        }
        if (request()->ajax() || request()->api == true) {
            return response()->json([], 404);
        }
        return abort(404);
    }
}
