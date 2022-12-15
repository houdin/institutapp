<?php

namespace App\Http\Controllers;

use Cart;
use Carbon\Carbon;
use Stripe\Charge;
use Stripe\Stripe;
use App\Models\Tax;
use PayPal\Api\Item;
use Stripe\Customer;
use App\Models\Order;
use PayPal\Api\Payer;
use App\Models\Coupon;
use PayPal\Api\Amount;
use App\Models\Premium;
use App\Models\Product;
use PayPal\Api\Payment;
use App\Models\Tutorial;
use PayPal\Api\ItemList;
use App\Models\Formation;
use App\Models\OrderItem;
use Illuminate\Support\Str;
use PayPal\Api\Transaction;
use PayPal\Rest\ApiContext;
use Illuminate\Http\Request;
use PayPal\Api\RedirectUrls;
use App\Mail\OfflineOrderMail;
use PayPal\Api\PaymentExecution;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Input;
use PayPal\Auth\OAuthTokenCredential;
use App\Helpers\General\EarningHelper;
use Illuminate\Support\Facades\Session;
use PHPUnit\Framework\Constraint\Count;
use Illuminate\Support\Facades\Redirect;
use App\Library\Transformer\CartTransformer;

class CartController extends Controller
{

    private $path;
    private $currency;

    public function __construct()
    {
        /** PayPal api context **/
        // $paypal_conf = \Config::get('paypal');
        // $this->_api_context = new ApiContext(
        //     new OAuthTokenCredential(
        //         $paypal_conf['client_id'],
        //         $paypal_conf['secret']
        //     )
        // );
        // $this->_api_context->setConfig($paypal_conf['settings']);

        $this->currency = getCurrency(config('app.currency'));
    }

    public function index(Request $request)
    {
        $cartContent = [];
        $cart_items = [];
        $total = 0;
        $userId = auth()->user()->id;
        if (auth()->check() && Cart::session($userId)) {

            $cart = Cart::session($userId);
            $cartContent = $cart->getContent();
            $cart_items = $cart->getContent()->keys()->toArray();
            $total = $cart->getTotal();
        } else {

            if (auth()->check() && Cart::getContent()->keys()) {
                $cart = Cart::getContent();
                Cart::clear();
                Cart::session($userId)->add($cart);
                $cart = Cart::session($userId);
                $cartContent = $cart->getContent();
                $cart_items = $cart->getContent()->keys()->toArray();
                $total = $cart->getTotal();
            } else {
                $cartContent = Cart::getContent();
                $cart_items = Cart::getContent()->keys()->toArray();
                $total = Cart::getTotal();
            }
        }

        $formation_ids = [];
        $bundle_ids = [];
        $products = new Collection;
        foreach ($cartContent as $item) {
            // if ($item->attributes->type == 'bundle') {
            //     $bundle_ids[] = $item->id;
            // } else {
            //     $formation_ids[] = $item->id;
            // }
            $products->push(('\App\Models\\' . ucfirst($item->attributes->type))::findOrFail($item->id));
        }
        $formations = new Collection(Formation::find($formation_ids));


        // $total = $formations->sum('price');
        $total = $products->sum('price');
        //Apply Tax
        $taxData = $this->applyTax('total');

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'products' => $products,
                'total' => $total,
                'taxData' => $taxData
            ]);
        }


        return view('frontend.cart.checkout', compact('products', 'total', 'taxData'));
    }

    public function addToCart(Request $request)
    {
        $this->validate($request, [
            'product_id' =>  'required|numeric',
            'quantity' =>  'required|numeric'
        ]);
        $product = "";
        $teachers = "";
        $type = $request->type;
        $cart_items = '';

        try {
            switch ($type) {
                case 'formation':
                    $product = Formation::findOrFail($request->get('product_id'));
                    $teachers = $product->teachers->pluck('id', 'name');
                    break;
                case 'bundle':
                    $product = Bundle::findOrFail($request->get('product_id'));
                    $teachers = $product->user->name;
                    break;
                case 'product':
                    $product = Product::findOrFail($request->get('product_id'));
                    break;
                case 'tutorial':
                    $product = Tutorial::findOrFail($request->get('product_id'));
                    break;
                case 'premium':
                    $product = Premium::findOrFail($request->get('product_id'));
                    break;
                default:
                    break;
            }



            if (auth()->check() && Cart::session(auth()->user()->id)) {
                $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
            } else {
                if (auth()->check() && Cart::getContent()->keys()) {
                    $cart = Cart::getContent();
                    Cart::clear();
                    Cart::session(auth()->user()->id)->add($cart);
                    $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
                } else {
                    $cart_items = Cart::getContent()->keys()->toArray();
                }
            }

            if (!in_array($product->id, $cart_items)) {
                if (auth()->check()) {
                    Cart::session(auth()->user()->id)
                        ->add(
                            $product->id,
                            $product->title,
                            $product->price,
                            1,
                            [
                                'user_id' => auth()->user()->id,
                                'description' => $product->description,
                                'image' => $product->formation_image,
                                'type' => $type,
                                'teachers' => $teachers
                            ]
                        )->associate('\App\Models\\' . ucfirst($type));
                } else {
                    Cart::add(
                        $product->id,
                        $product->title,
                        $product->price,
                        1,
                        [
                            'user_id' => '',
                            'description' => $product->description,
                            'image' => $product->formation_image,
                            'type' => $type,
                            'teachers' => $teachers
                        ]
                    )->associate('\App\Models\\' . ucfirst($type));
                }
            } else {
                if ($type === 'product') {
                    if (auth()->check()) {
                        Cart::session(auth()->user()->id)
                            ->update(
                                $product->id,
                                ['quantity' => 1]
                            );
                    } else {
                        Cart::update(
                            $product->id,
                            ['quantity' => 1]
                        );
                    }
                }
            }
            $message = "You added {$product->title} to your cart!";
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error adding to your cart.  Please try again', 422);
        }

        Session::flash('success', trans('labels.frontend.cart.product_added'));
        // return back();
        return response()->json([
            'cart' =>  CartTransformer::transform(),
            'message' => $message
        ], 200);
    }

    public function checkout(Request $request)
    {
        $product = "";
        $teachers = "";
        $type = "";
        $bundle_ids = [];
        $formation_ids = [];

        $this->validate($request, [
            'product_id' =>  'required|numeric',
            'quantity' =>  'required|numeric'
        ]);
        $product = "";
        $teachers = "";
        $type = $request->type;
        $cart_items = '';

        try {
            switch ($type) {
                case 'formation':
                    $product = Formation::findOrFail($request->get('product_id'));
                    $teachers = $product->teachers->pluck('id', 'name');
                    break;
                case 'bundle':
                    $product = Bundle::findOrFail($request->get('product_id'));
                    $teachers = $product->user->name;
                    break;
                case 'product':
                    $product = Product::findOrFail($request->get('product_id'));
                    break;
                case 'tutorial':
                    $product = Tutorial::findOrFail($request->get('product_id'));
                    break;
                case 'premium':
                    $product = Premium::findOrFail($request->get('product_id'));
                    break;
                default:
                    break;
            }



            if (auth()->check() && Cart::session(auth()->user()->id)) {
                $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
            } else {
                if (auth()->check() && Cart::getContent()->keys()) {
                    $cart = Cart::getContent();
                    Cart::clear();
                    Cart::session(auth()->user()->id)->add($cart);
                    $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();
                } else {
                    $cart_items = Cart::getContent()->keys()->toArray();
                }
            }

            if (!in_array($product->id, $cart_items)) {
                if (auth()->check()) {
                    Cart::session(auth()->user()->id)
                        ->add(
                            $product->id,
                            $product->title,
                            $product->price,
                            1,
                            [
                                'user_id' => auth()->user()->id,
                                'description' => $product->description,
                                'image' => $product->formation_image,
                                'type' => $type,
                                'teachers' => $teachers
                            ]
                        )->associate('\App\Models\\' . ucfirst($type));
                } else {
                    Cart::add(
                        $product->id,
                        $product->title,
                        $product->price,
                        1,
                        [
                            'user_id' => '',
                            'description' => $product->description,
                            'image' => $product->formation_image,
                            'type' => $type,
                            'teachers' => $teachers
                        ]
                    )->associate('\App\Models\\' . ucfirst($type));
                }
            } else {
                if ($type === 'product') {
                    if (auth()->check()) {
                        Cart::session(auth()->user()->id)
                            ->update(
                                $product->id,
                                ['quantity' => 1]
                            );
                    } else {
                        Cart::update(
                            $product->id,
                            ['quantity' => 1]
                        );
                    }
                }
            }
            $message = "You added {$product->title} to your cart!";
        } catch (\Exception $exception) {
            return $this->hasError('Sorry there was an error adding to your cart.  Please try again', 422);
        }



        if ($request->has('formation_id')) {
            $product = Formation::findOrFail($request->get('formation_id'));
            $teachers = $product->teachers->pluck('id', 'name');
            $type = 'formation';
        } elseif ($request->has('bundle_id')) {
            $product = Bundle::findOrFail($request->get('bundle_id'));
            $teachers = $product->user->name;
            $type = 'bundle';
        }

        $cart_items = Cart::session(auth()->user()->id)->getContent()->keys()->toArray();

        if (!in_array($product->id, $cart_items)) {

            Cart::session(auth()->user()->id)
                ->add(
                    $product->id,
                    $product->title,
                    $product->price,
                    1,
                    [
                        'user_id' => auth()->user()->id,
                        'description' => $product->description,
                        'image' => $product->image->url,
                        'type' => $type,
                        'teachers' => $teachers
                    ]
                );
        }
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $formation_ids[] = $item->id;
            }
        }
        $formations = new Collection(Formation::find($formation_ids));


        $total = $formations->sum('price');

        //Apply Tax
        $taxData = $this->applyTax('total');

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'products' => $products,
                'total' => $total,
                'taxData' => $taxData
            ]);
        }


        return view('frontend.cart.checkout', compact('formations', 'total', 'taxData'));
    }

    public function clear(Request $request)
    {
        Cart::session(auth()->user()->id)->clear();
        return back();
    }

    public function remove(Request $request)
    {
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');


        if (Cart::session(auth()->user()->id)->getContent()->count() < 2) {
            Cart::session(auth()->user()->id)->clearCartConditions();
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');
            Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
            Cart::session(auth()->user()->id)->clear();
        }
        Cart::session(auth()->user()->id)->remove($request->formation);
        return redirect(route('cart.index'));
    }

    public function stripePayment(Request $request)
    {
        if ($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }
        //Making Order
        $order = $this->makeOrder();

        //Charging Customer
        $status = $this->createStripeCharge($request);

        if ($status == 'success') {
            $order->status = 1;
            $order->payment_type = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->formations as $formation) {
                        $formation->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);

            Cart::session(auth()->user()->id)->clear();
            return redirect()->route('status');
        } else {
            $order->status = 2;
            $order->save();
            return redirect()->route('cart.index');
        }
    }

    // public function paypalPayment(Request $request)
    // {
    //     if ($this->checkDuplicate()) {
    //         return $this->checkDuplicate();
    //     }
    //     $payer = new Payer();
    //     $payer->setPaymentMethod('paypal');
    //     $items = [];

    //     $cartItems = Cart::session(auth()->user()->id)->getContent();
    //     $cartTotal = Cart::session(auth()->user()->id)->getTotal();
    //     $currency = $this->currency['short_code'];

    //     foreach ($cartItems as $cartItem) {

    //         $item_1 = new Item();
    //         $item_1->setName($cartItem->name)
    //             /** item name **/
    //             ->setCurrency($currency)
    //             ->setQuantity(1)
    //             ->setPrice($cartItem->price);
    //         /** unit price **/
    //         $items[] = $item_1;
    //     }

    //     $item_list = new ItemList();
    //     $item_list->setItems($items);

    //     $amount = new Amount();
    //     $amount->setCurrency($currency)
    //         ->setTotal($cartTotal);


    //     $transaction = new Transaction();
    //     $transaction->setAmount($amount)
    //         ->setItemList($item_list)
    //         ->setDescription(auth()->user()->name);

    //     $redirect_urls = new RedirectUrls();
    //     $redirect_urls->setReturnUrl(URL::route('cart.paypal.status'))
    //         /** Specify return URL **/
    //         ->setCancelUrl(URL::route('cart.paypal.status'));
    //     $payment = new Payment();
    //     $payment->setIntent('Sale')
    //         ->setPayer($payer)
    //         ->setRedirectUrls($redirect_urls)
    //         ->setTransactions(array($transaction));
    //     /** dd($payment->create($this->_api_context));exit; **/
    //     try {
    //         $payment->create($this->_api_context);
    //     } catch (\PayPal\Exception\PayPalConnectionException $ex) {
    //         if (\Config::get('app.debug')) {
    //             \Session::put('failure', trans('labels.frontend.cart.connection_timeout'));
    //             return Redirect::route('cart.paypal.status');
    //         } else {
    //             \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
    //             return Redirect::route('cart.paypal.status');
    //         }
    //     }

    //     foreach ($payment->getLinks() as $link) {
    //         if ($link->getRel() == 'approval_url') {
    //             $redirect_url = $link->getHref();
    //             break;
    //         }
    //     }
    //     /** add payment ID to session **/
    //     Session::put('paypal_payment_id', $payment->getId());
    //     if (isset($redirect_url)) {
    //         /** redirect to paypal **/
    //         return Redirect::away($redirect_url);
    //     }
    //     \Session::put('failure', trans('labels.frontend.cart.unknown_error'));
    //     return Redirect::route('cart.paypal.status');
    // }

    public function offlinePayment(Request $request)
    {
        if ($this->checkDuplicate()) {
            return $this->checkDuplicate();
        }
        //Making Order
        $order = $this->makeOrder();
        $order->payment_type = 3;
        $order->status = 0;
        $order->save();
        $content = [];
        $items = [];
        $counter = 0;
        foreach (Cart::session(auth()->user()->id)->getContent() as $key => $cartItem) {
            $counter++;
            array_push($items, ['number' => $counter, 'name' => $cartItem->name, 'price' => $cartItem->price]);
        }

        $content['items'] = $items;
        $content['total'] = Cart::session(auth()->user()->id)->getTotal();
        $content['reference_no'] = $order->reference_no;

        try {
            \Mail::to(auth()->user()->email)->send(new OfflineOrderMail($content));
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for order ' . $order->id);
        }

        Cart::session(auth()->user()->id)->clear();
        \Session::flash('success', trans('labels.frontend.cart.offline_request'));
        return redirect()->route('formations.all');
    }

    public function getPaymentStatus()
    {
        /** Get the payment ID before session clear **/
        $payment_id = Session::get('paypal_payment_id');
        /** clear the session payment ID **/
        Session::forget('paypal_payment_id');
        if (empty(Input::get('PayerID')) || empty(Input::get('token'))) {
            \Session::put('failure', trans('labels.frontend.cart.payment_failed'));
            return Redirect::route('status');
        }
        $payment = Payment::get($payment_id, $this->_api_context);
        $order = $this->makeOrder();
        $order->payment_type = 2;
        $order->save();
        $execution = new PaymentExecution();
        $execution->setPayerId(Input::get('PayerID'));
        /**Execute the payment **/
        $result = $payment->execute($execution, $this->_api_context);
        if ($result->getState() == 'approved') {
            \Session::flash('success', trans('labels.frontend.cart.payment_done'));
            $order->status = 1;
            $order->save();
            (new EarningHelper)->insert($order);
            foreach ($order->items as $orderItem) {
                //Bundle Entries
                if ($orderItem->item_type == Bundle::class) {
                    foreach ($orderItem->item->formations as $formation) {
                        $formation->students()->attach($order->user_id);
                    }
                }
                $orderItem->item->students()->attach($order->user_id);
            }

            //Generating Invoice
            generateInvoice($order);
            Cart::session(auth()->user()->id)->clear();
            return Redirect::route('status');
        } else {
            \Session::flash('failure', trans('labels.frontend.cart.payment_failed'));
            $order->status = 2;
            $order->save();
            return Redirect::route('status');
        }
    }

    public function getNow(Request $request)
    {
        $this->validate($request, [
            'product_id' =>  'required|numeric',
            'type' => 'required|alpha',

        ]);

        $product = "";
        $teachers = "";
        $user_id = "";
        $transportable = false;
        //$type = Str::ucfirst($request->type );
        $product = ('\App\Models\\' . ucfirst($request->type))::findOrFail($request->product_id);

        if (($product->published == 0) && ($product == false)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([], 404);
            }
            abort(404);
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = Str::random(8);
        $order->amount = 0;
        $order->status = 1;
        $order->payment_type = 0;
        $order->save();
        $type = ('\App\Models\\' . ucfirst($request->type));
        //Getting and Adding items

        $order->items()->create([
            'item_id' => $request->product_id,
            'item_type' => $type,
            'price' => 0
        ]);

        foreach ($order->items as $orderItem) {
            //Bundle Entries
            if ($orderItem->item_type == Bundle::class) {
                foreach ($orderItem->item->formations as $formation) {
                    $formation->students()->attach($order->user_id);
                }
            }
            $orderItem->item->students()->attach($order->user_id);
        }
        Session::flash('success', trans('labels.frontend.cart.purchase_successful'));

        if (request()->ajax() || request()->api == true) {
            return response()->json([
                'redirect' => 'back',
                'success' => true,
                'message' => trans('labels.frontend.cart.purchase_successful')
            ]);
        }
        return back();
    }

    public function isPurchased($formation_id)
    {

        $formation = Formation::where('id', $formation_id)
            ->firstOrFail();

        $purchased_formation = \Auth::check() && $formation->students()->where('user_id', \Auth::id())->count() > 0;
        if (($formation->published == 0) && ($purchased_formation == false)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([], 404);
            }
            abort(404);
        }
        if (($formation->published == 1) && ($purchased_formation == true)) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'purchased' => true
                ]);
            }
            abort(404);
        }
    }

    public function getOffers()
    {
        $coupons = Coupon::where('status', '=', 1)->get();
        return view('frontend.cart.offers', compact('coupons'));
    }

    public function applyCoupon(Request $request)
    {
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');

        $coupon = $request->coupon;
        $coupon = Coupon::where('code', '=', $coupon)
            ->where('status', '=', 1)
            ->first();
        if ($coupon != null) {
            Cart::session(auth()->user()->id)->clearCartConditions();
            Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');

            $ids = Cart::session(auth()->user()->id)->getContent()->keys();
            $formation_ids = [];
            $bundle_ids = [];
            foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
                if ($item->attributes->type == 'bundle') {
                    $bundle_ids[] = $item->id;
                } else {
                    $formation_ids[] = $item->id;
                }
            }
            $formations = new Collection(Formation::find($formation_ids));
            $bundles = Bundle::find($bundle_ids);
            $formations = $bundles->merge($formations);

            $total = $formations->sum('price');
            $isCouponValid = false;
            if ($coupon->useByUser() < $coupon->per_user_limit) {
                $isCouponValid = true;
                if (($coupon->min_price != null) && ($coupon->min_price > 0)) {
                    if ($total >= $coupon->min_price) {
                        $isCouponValid = true;
                    }
                } else {
                    $isCouponValid = true;
                }
                if ($coupon->expires_at != null) {
                    if (Carbon::parse($coupon->expires_at) >= Carbon::now()) {
                        $isCouponValid = true;
                    } else {
                        $isCouponValid = false;
                    }
                }
            }

            if ($isCouponValid == true) {
                $type = null;
                if ($coupon->type == 1) {
                    $type = '-' . $coupon->amount . '%';
                } else {
                    $type = '-' . $coupon->amount;
                }

                $condition = new \Darryldecode\Cart\CartCondition(array(
                    'name' => $coupon->code,
                    'type' => 'coupon',
                    'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                    'value' => $type,
                    'order' => 1
                ));

                Cart::session(auth()->user()->id)->condition($condition);
                //Apply Tax
                $taxData = $this->applyTax('subtotal');

                $html = view('frontend.cart.partials.order-stats', compact('total', 'taxData'))->render();
                return ['status' => 'success', 'html' => $html];
            }
        }
        return ['status' => 'fail', 'message' => trans('labels.frontend.cart.invalid_coupon')];
    }

    public function removeCoupon(Request $request)
    {

        Cart::session(auth()->user()->id)->clearCartConditions();
        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        Cart::session(auth()->user()->id)->removeConditionsByType('tax');

        $formation_ids = [];
        $bundle_ids = [];
        foreach (Cart::session(auth()->user()->id)->getContent() as $item) {
            if ($item->attributes->type == 'bundle') {
                $bundle_ids[] = $item->id;
            } else {
                $formation_ids[] = $item->id;
            }
        }
        $formations = new Collection(Formation::find($formation_ids));
        $bundles = Bundle::find($bundle_ids);
        $formations = $bundles->merge($formations);

        $total = $formations->sum('price');

        //Apply Tax
        $taxData = $this->applyTax('subtotal');

        $html = view('frontend.cart.partials.order-stats', compact('total', 'taxData'))->render();
        return ['status' => 'success', 'html' => $html];
    }

    private function makeOrder()
    {
        $coupon = auth()->check() ? Cart::session(auth()->user()->id)->getConditionsByType('coupon')->first() : Cart::getConditionsByType('coupon')->first();
        if ($coupon != null) {
            $coupon = Coupon::where('code', '=', $coupon->getName())->first();
        }

        $order = new Order();
        $order->user_id = auth()->user()->id;
        $order->reference_no = Str::random(8);
        $order->amount = auth()->check() ? Cart::session(auth()->user()->id)->getTotal() : Cart::getTotal();
        $order->status = 1;
        $order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
        $order->payment_type = 3;
        $order->save();
        //Getting and Adding items
        $cartContent = auth()->check() ? Cart::session(auth()->user()->id)->getContent() : Cart::getContent();
        foreach ($cartContent as $cartItem) {
            //$type = get_class(('App\Models\\' . ucfirst($cartItem->attributes->type))::all());
            $order->items()->create([
                'item_id' => $cartItem->id,
                'item_type' => 'App\Models\\' . ucfirst($cartItem->attributes->type),
                'price' => $cartItem->price
            ]);
        }
        //        Cart::session(auth()->user()->id)->removeConditionsByType('coupon');
        return $order;
    }

    private function checkDuplicate()
    {
        $is_duplicate = false;
        $message = '';
        $orders = Order::where('user_id', '=', auth()->user()->id)->pluck('id');
        $order_items = OrderItem::whereIn('order_id', $orders)->get(['item_id', 'item_type']);
        $cartContent = [];
        if (auth()->check()) {
            $cartContent = Cart::session(auth()->user()->id)->getContent();
        } else {
            $cartContent = Cart::getContent();
        }
        foreach ($cartContent as $cartItem) {
            if ($cartItem->attributes->type) {
                foreach ($order_items->where('item_type', 'App\Models\\' . ucfirst($cartItem->attributes->type)) as $item) {
                    if ($item->item_id == $cartItem->id) {
                        $is_duplicate = true;
                        // $message .= $cartItem->name . ' ' . __('alerts.frontend.duplicate_formation') . '</br>';
                        $message .= $cartItem->name . ' ' . __('alerts.frontend.duplicate_' . $cartItem->attributes->type) . '</br>';
                    }
                }
            }
            // if ($cartItem->attributes->type == 'bundle') {
            //     foreach ($order_items->where('item_type', 'App\Models\Bundle') as $item) {
            //         if ($item->item_id == $cartItem->id) {
            //             $is_duplicate = true;
            //             $message .= $cartItem->name . '' . __('alerts.frontend.duplicate_bundle') . '</br>';
            //         }
            //     }
            // }
        }

        if ($is_duplicate) {
            if (request()->ajax() || request()->api == true) {
                return response()->json([
                    'message_type' => 'danger',
                    'message' => $message
                ]);
            }

            return redirect()->back()->withdanger($message);
        }
        return false;
    }

    private function createStripeCharge($request)
    {
        $status = "";
        Stripe::setApiKey(config('services.stripe.secret'));
        $amount = Cart::session(auth()->user()->id)->getTotal();
        $currency = $this->currency['short_code'];
        try {
            Charge::create(array(
                "amount" => $amount * 100,
                "currency" => strtolower($currency),
                "source" => $request->reservation['stripe_token'], // obtained with Stripe.js
                "description" => auth()->user()->name
            ));
            $status = "success";
            Session::flash('success', trans('labels.frontend.cart.payment_done'));
        } catch (\Exception $e) {
            \Log::info($e->getMessage() . ' for id = ' . auth()->user()->id);
            Session::flash('failure', trans('labels.frontend.cart.try_again'));
            $status = "failure";
        }
        return $status;
    }

    private function applyTax($target)
    {
        //Apply Conditions on Cart
        $taxes = Tax::where('status', '=', 1)->get();
        if (auth()->check()) {
            Cart::session(auth()->user()->id)->removeConditionsByType('tax');
        } else {
            Cart::removeConditionsByType('tax');
        }

        if ($taxes != null) {
            $taxData = [];
            foreach ($taxes as $tax) {
                $total = auth()->check() ? Cart::session(auth()->user()->id)->getTotal() : Cart::getTotal();
                $taxData[] = ['name' => '+' . $tax->rate . '% ' . $tax->name, 'amount' => $total * $tax->rate / 100];
            }

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Tax',
                'type' => 'tax',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => $taxes->sum('rate') . '%',
                'order' => 2
            ));
            auth()->check() ? Cart::session(auth()->user()->id)->condition($condition) : Cart::condition($condition);
            return $taxData;
        }
    }
}
