<?php

namespace App\Http\Controllers\Backend;

use App\Models\Bundle;
use App\Models\Formation;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\DB;

class ReportController extends BackendBaseController
{
    public function getSalesReport()
    {

        $formations = Formation::ofTeacher()->pluck('id');
        $bundles = Bundle::ofTeacher()->pluck('id');


        $bundle_earnings = Order::with('items')->whereHas('items', function ($q) use ($bundles) {
            $q->where('item_type', '=', Bundle::class)
                ->whereIn('item_id', $bundles);
        })->where('status', '=', 1);


        $bundle_sales = $bundle_earnings->count();
        $bundle_earnings = $bundle_earnings->sum('amount');

        $formation_earnings = Order::with('items')->whereHas('items', function ($q) use ($formations) {
            $q->where('item_type', '=', Formation::class)
                ->whereIn('item_id', $formations);
        })->where('status', '=', 1);

        $formation_sales = $formation_earnings->count();
        $formation_earnings = $formation_earnings->sum('amount');

        $total_earnings = $formation_earnings + $bundle_earnings;
        $total_sales = $formation_sales + $bundle_sales;

        return view('backend.reports.sales', compact('total_earnings', 'total_sales'));
    }

    public function getStudentsReport()
    {
        return view('backend.reports.students');
    }

    public function getFormationData(Request $request)
    {

        $formations = Formation::ofTeacher()->pluck('id');

        $formation_orders = OrderItem::whereHas('order', function ($q) {
            $q->where('status', '=', 1);
        })->where('item_type', '=', Formation::class)
            ->whereIn('item_id', $formations)
            ->join('formations', 'order_items.item_id', '=', 'formations.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select('item_id', DB::raw('count(*) as orders, sum(orders.amount) as earnings, formations.title as name, formations.slug'))
            ->groupBy('item_id')
            ->get();

        return \DataTables::of($formation_orders)
            ->addIndexColumn()
            ->addColumn('formation', function ($q) {
                $formation_name = $q->title;
                $formation_slug = $q->slug;
                $link = "<a href='" . route('formations.show', [$formation_slug]) . "' target='_blank'>" . $formation_name . "</a>";
                return $link;
            })
            ->rawColumns(['formation'])
            ->make();
    }

    public function getBundleData(Request $request)
    {
        $bundles = Bundle::ofTeacher()->has('students', '>', 0)->withCount('students')->pluck('id');

        $bundle_orders = OrderItem::whereHas('order', function ($q) {
            $q->where('status', '=', 1);
        })->where('item_type', '=', Bundle::class)
            ->whereIn('item_id', $bundles)
            ->join('bundles', 'order_items.item_id', '=', 'bundles.id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->select('item_id', DB::raw('count(*) as orders, sum(orders.amount) as earnings, bundles.title as name, bundles.slug'))
            ->groupBy('item_id')
            ->get();


        return \DataTables::of($bundle_orders)
            ->addIndexColumn()
            ->addColumn('bundle', function ($q) {
                $bundle_name = $q->title;
                $bundle_slug = $q->slug;
                $link = "<a href='" . route('bundles.show', [$bundle_slug]) . "' target='_blank'>" . $bundle_name . "</a>";
                return $link;
            })
            ->addColumn('students', function ($q) {
                return $q->students_count;
            })
            ->rawColumns(['bundle'])
            ->make();
    }

    public function getStudentsData(Request $request)
    {
        $formations = Formation::ofTeacher()->has('students', '>', 0)->withCount('students')->get();

        return \DataTables::of($formations)
            ->addIndexColumn()
            ->addColumn('completed', function ($q) {
                $count = 0;
                if (count($q->students) > 0) {
                    foreach ($q->students as $student) {
                        $completed_modules =  $student->chapters()->where('formation_id', $q->id)->get()->pluck('model_id')->toArray();
                        if (count($completed_modules) > 0) {
                            $progress = intval(count($completed_modules) / $q->formationTimeline->count() * 100);
                            if ($progress == 100) {
                                $count++;
                            }
                        }
                    }
                }
                return $count;
            })
            ->make();
    }
}
