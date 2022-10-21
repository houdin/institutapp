<?php

namespace App\Http\Controllers\Frontend\User;


use App\Library\Transformer\UserAccountTransformer;
use App\Models\Order;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Http\Controllers\Frontend\FrontendBaseController;
use Illuminate\Support\Facades\Auth;

class UserAccountController extends UserPagesController
{
    /**
     * @var Order
     */
    protected $order;

    /**
     * Must be logged in to access this page
     * UserAddressController constructor.
     * @param Order $order
     */
    public function __construct(Order $order)
    {
        $this->middleware('auth');
        $this->order = $order;
    }

    /**
     * shows the users account information
     *
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'user' => UserAccountTransformer::transform(Auth::user())
            ]);
        }
        // return view('frontend.products.account', [
        //     'user' => json_encode(UserAccountTransformer::transform(Auth::user()))
        // ]);
    }


    /**
     * returns a view with information about a single order.  This is rendered in the
     * user accounts page
     *
     * @param $id
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View | RedirectResponse
     */
    public function show($id)
    {
        if (
            !$this->order->exists((int)$id)  ||
            !$this->order->find((int)$id)->belongsToUser(Auth::user()->id)
        ) {
            return $this->hasError('The order you selected does not belong to your account');
        }

        return view('frontend.products.accountOrder', [
            'order_id' => (int)$id
        ]);
    }
}
