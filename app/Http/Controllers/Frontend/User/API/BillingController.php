<?php

namespace App\Http\Controllers\Frontend\User\API;


use Darryldecode\Cart\Cart;
use App\Library\Order\ShippingDateEstimator;

use App\Http\Requests\ecommerce\BillingFormRequest;
use App\Http\Controllers\Frontend\FrontendBaseController;


class BillingController extends FrontendBaseController
{
    /**
     * OrderController constructor.
     */
    function __construct()
    {
        $this->middleware('ajax.auth');
    }


    /**
     * Processes a user payment and returns the response
     *
     * @param BillingFormRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(BillingFormRequest $request)
    {
        try {
            $request->save();
            $request->updateUserPaid();
        } catch (\Exception $e) {
            return response()->json([
                'status' => $e->getMessage()
            ], 422);
        }
        Cart::clear();
        session()->forget('user_order');

        return response()->json([
            'status' => 'Your payment was accepted!',
            'estimated_arrival_date' => ShippingDateEstimator::arrivalDate(new \DateTime()),
            'data' => $request->getOrder()
        ], 200);
    }
}
