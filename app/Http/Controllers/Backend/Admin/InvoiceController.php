<?php

namespace App\Http\Controllers\Backend\Admin;

use App\Models\Formation;
use App\Models\Order;
use Illuminate\Http\Request;
use App\Http\Controllers\Backend\BackendBaseController;
use Illuminate\Support\Facades\Response;

class InvoiceController extends BackendBaseController
{
    /**
     * Get invoice list of current user
     *
     * @param Request $request
     */
    public function getIndex(){

        $invoices = auth()->user()->invoices()->whereHas('order')->get();
        return view('backend.invoices.index',compact('invoices'));
    }


    /**
     * Download order invoice
     *
     * @param Request $request
     */
    public function getInvoice(Request $request)
    {
        if (auth()->check()) {
            $order = Order::findOrFail($request->order);
            if (auth()->user()->isAdmin() || ($order->user_id == auth()->user()->id)) {
                $file = storage_path() . "/app/invoices/" . $order->invoice->url;
                return Response::download($file);
            }
        }
        return abort(404);
    }

}
