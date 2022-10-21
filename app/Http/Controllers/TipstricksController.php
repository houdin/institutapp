<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use App\Models\Category;
use App\Models\Formation;
use App\Models\Tipstrick;
use Illuminate\Http\Request;

class TipstricksController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $tipstricks = Tipstrick::withoutGlobalScope('filter')
            ->where('published', 1)
            ->orderBy('id', 'desc')
            ->paginate(9);


        $categories = Category::where('status', '=', 1)->get();

        if (\Auth::check()) {
            $purchased_formations = Formation::withoutGlobalScope('filter')->whereHas('students', function ($query) {
                $query->where('id', \Auth::id());
            })
                ->with('modules')
                ->orderBy('id', 'desc')
                ->get();
        }

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'tipstricks' => $tipstricks,
                'categories' => $categories,

            ]);
        }



        return view('frontend.tipstricks.index', compact('tipstricks', 'categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tipstrick  $tipstrick
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $tipstrick = Tipstrick::where('slug', $slug)->firstOrFail();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'tipstrick' => $tipstrick,

            ]);
        }

        return view('frontend.tipstricks.tipstrick', compact('tipstrick'));
    }
}
