<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Portfolio;
use Illuminate\Http\Request;

class PortfolioController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $portfolios = Portfolio::where('published', '=', 1)->get();

        $categories = Category::where('status', '=', 1)->get();

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'portfolios' => $portfolios,
                'categories' => $categories,

            ]);
        }

        return view('frontend.portfolios.index', compact('portfolios', 'categories'));
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
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function show($slug)
    {
        $portfolio = Portfolio::withoutGlobalScope('filter')->where('slug', $slug)->firstOrFail();

        $previous_id = Portfolio::where('id', '<', $portfolio->id)->max('id');
        $previous = Portfolio::find($previous_id);

        // get next user id
        $next_id = Portfolio::where('id', '>', $portfolio->id)->min('id');
        $next = Portfolio::find($next_id);

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'portfolio' => $portfolio,
                'previous' => $previous,
                'next' => $next,

            ]);
        }


        return view('frontend.portfolios.portfolio', compact('portfolio', 'previous', 'next'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function edit(Portfolio $portfolio)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Portfolio $portfolio)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Portfolio  $portfolio
     * @return \Illuminate\Http\Response
     */
    public function destroy(Portfolio $portfolio)
    {
        //
    }
}
