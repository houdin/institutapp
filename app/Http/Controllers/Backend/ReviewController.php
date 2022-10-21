<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendBaseController;
use App\Models\Review;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReviewController extends BackendBaseController
{
    /**
     * Display a listing of Category.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('backend.reviews.index');
    }

    /**
     * Display a listing of Formations via ajax DataTable.
     *
     * @return \Illuminate\Http\Response
     */
    public function getData(Request $request)
    {
        $reviews = "";
        $formations_id = auth()->user()->formations()->has('reviews')->pluck('id')->toArray();
        $reviews = Review::where('reviewable_type','=','App\Models\Formation')
            ->whereIn('reviewable_id',$formations_id)
            ->orderBy('created_at', 'desc')
            ->get();


        return DataTables::of($reviews)
            ->addIndexColumn()
            ->editColumn('created_at', function ($q) {
                return $q->created_at->format('d M, Y | H:i A');
            })
            ->addColumn('formation', function ($q) {
               $formation_name = $q->reviewable->title;
               $formation_slug = $q->reviewable->slug;
               $link = "<a href='".route('formations.show', [$formation_slug])."' target='_blank'>".$formation_name."</a>";
               return $link;
            })
            ->addColumn('user',function ($q){
                return $q->user->full_name;
            })
            ->rawColumns(['formation'])
            ->make();
    }
}
