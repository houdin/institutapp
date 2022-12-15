<?php

namespace App\Http\Controllers;
/*
|--------------------------------------------------------------------------
| OrdersController.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for returning views with order information.  Routes
| that return ajax requests are in the Controllers\User\API\OrdersController.php
| file
*/


use App\Http\Requests\ecommerce\UserOrderRequest;
use App\Http\Controllers\User\UserPagesController;

use App\Library\API\ApiResponseTracker;
use App\Library\Transformer\AddressTransformer;
use App\Library\Transformer\OrderTransformers;
use App\Library\Transformer\UserAddressTransformer;
use App\Models\Order;
use App\Models\Auth\User;
use Illuminate\Support\Facades\Auth;

class QuotationsController extends UserPagesController
{
    protected $allowed = [
        'type', 'select-address', 'payment', 'invoice'
    ];

    /**
     * @var string
     */
    protected $redirect = 'devis/type';

    protected $getParameter;

    /**
     * Must be logged in to access this page
     * UserAddressController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * When the user wants to check out this will return the check out view page
     * The allowed property determines what stages are allowed
     *
     * @param $stage : what stage of the order process is the user in
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\View\View|\Psy\Util\Json
     */
    public function index($stage)
    {


        $this->getParameter = $stage;
        return $this->isAllowed($stage);
    }


    /**
     * returns a view with the user shopping cart information
     * if the stage parameter from the index method was in the allowed array
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    protected function onSuccess()
    {
        return view('frontend.quotation.index', [
            'order' => json_encode($this->getOrder()),
            'stage' => $this->getParameter
        ]);
    }

    /**
     * gets an array of details about the user's current order if a previous order was created
     *
     * @return bool | array
     */
    private function getOrder()
    {
        $order = session()->get('user_order');
        if (is_null($order)) {
            return false;
        }
        return $order['order'];
    }
}
