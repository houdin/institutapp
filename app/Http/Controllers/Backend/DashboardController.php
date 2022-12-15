<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Backend\BackendBaseController;
use App\Models\Auth\User;
use App\Models\Bundle;
use App\Models\Contact;
use App\Models\Formation;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Review;
use Illuminate\Database\Eloquent\Collection;
use Inertia\Inertia;

/**
 * Class DashboardController.
 */
class DashboardController extends BackendBaseController
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        // dd($user);

        $purchased_formations = NULL;
        $students_count = NULL;
        $recent_reviews = NULL;
        $threads = NULL;
        $teachers_count = NULL;
        $formations_count = NULL;
        $pending_orders = NULL;
        $recent_orders = NULL;
        $recent_contacts = NULL;
        $purchased_bundles = NULL;
        if (\Auth::check()) {

            $purchased_formations = auth()->user()->purchasedFormations();
            $purchased_bundles = auth()->user()->purchasedBundles();
            $pending_orders = auth()->user()->pendingOrders();

            if (auth()->user()->hasRole('teacher')) {
                //IF logged in user is teacher
                $students_count = Formation::whereHas('teachers', function ($query) {
                    $query->where('user_id', '=', auth()->user()->id);
                })
                    ->withCount('students')
                    ->get()
                    ->sum('students_count');


                $formations_id = auth()->user()->formations()->has('reviews')->pluck('id')->toArray();
                $recent_reviews = Review::where('reviewable_type', '=', 'App\Models\Formation')
                    ->whereIn('reviewable_id', $formations_id)
                    ->orderBy('created_at', 'desc')
                    ->take(10)
                    ->get();



                $unreadThreads = [];
                $threads = [];
                if (auth()->user()->threads) {
                    foreach (auth()->user()->threads as $item) {
                        if ($item->unreadMessagesCount > 0) {
                            $unreadThreads[] = $item;
                        } else {
                            $threads[] = $item;
                        }
                    }
                    $threads = Collection::make(array_merge($unreadThreads, $threads))->take(10);
                }
            } elseif (\Auth::user()->hasRole('administrator')) {
                $students_count = User::role('student')->count();
                $teachers_count = User::role('teacher')->count();
                $formations_count = \App\Models\Formation::all()->count() + \App\Models\Bundle::all()->count();
                $recent_orders = Order::orderBy('created_at', 'desc')->take(10)->get();
                $recent_contacts = Contact::orderBy('created_at', 'desc')->take(10)->get();
            }
        }

        return view('backend.dashboard', compact('purchased_formations', 'students_count', 'recent_reviews', 'threads', 'purchased_bundles', 'teachers_count', 'formations_count', 'recent_orders', 'recent_contacts', 'pending_orders'));
    }
}
