<?php
/*
|--------------------------------------------------------------------------
| OrderDatabase.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving an App\Models\orders object and adding
| or editing items from the database.  It will return a response based on
| if the order was created successfully.  If it is successful then it will
| create a session with the order information
| The session is used to retrieve order information if the user refreshes the
| page
*/

namespace App\Library\Order;


use App\Models\Address;
use Cart;
use App\Models\Order;
use App\Models\Auth\User;
use Carbon\Carbon;

class OrderDatabase
{
    /**
     * @var Order
     */
    protected static $order;

    /**
     * response to provide the user
     *
     * @var array
     */
    protected static $response = [];

    /**
     * @var integer
     */
    protected static $address;

    /**
     * @var User
     */
    protected static $user;

    /**
     * creates a new order and returns a message
     *
     * @param Order $order
     * @param Address $address
     * @param User $user
     * @return Order
     */
    public static function createOrder(Order $order, Address $address, User $user)
    {
        self::$address = $address;
        self::$order = $order;
        self::$user = $user;
        self::addToDatabase();
        return self::$order;
    }

    /**
     * @param Order $order
     * @param Address $address
     * @return void
     */
    public static function updateOrder(Order $order, Address $address)
    {
        $order->update([
            'address_id' => $address->id,
        ]);
        $order->save();
    }

    /**
     * adds products to the orders products table
     *
     * @param Order $order
     * @param Cart $cart
     * @return void
     */
    public static function addProducts(Order $order, Cart $cart)
    {
        self::$order = $order;
        self::refreshProducts();
        foreach ($cart->session(auth()->user()->id)->getContent() as $item) {
            self::$order
                ->products()
                ->attach($item->id, ['quantity' => $item->quantity]);
        }
    }

    /**
     * add pricing information to the order
     *
     * @param Order $order
     * @param Cart $cart
     * @return void
     */
    public static function addPricing(Order $order,  Cart $cart)
    {
        $userId = auth()->user()->id;

        $order->update([
            'sub_total'     => money_format('%.2n', $cart->getSubTotal()),
            'total'         => money_format('%.2n', $cart->getTotal()),
            'taxes'         => money_format('%.2n', $cart->taxAmount)
        ]);
    }

    /**
     * adds relevant information to the database
     *
     * @return void
     */
    private static function addToDatabase()
    {
        $today = date("Ymd");
        $rand = strtoupper(substr(uniqid(sha1(time())), 0, 4));

        self::$order->address_id = self::$address['id'];
        self::$order->reference_no = $today . $rand;
        self::$order->user_id = self::$user->id;
        self::$order->amount = Cart::session(auth()->user()->id)->getTotal();
        self::$order->status = 1;
        self::$order->shipped = 0;
        // self::$order->coupon_id = ($coupon == null) ? 0 : $coupon->id;
        self::$order->payment_type = 3;
        self::$order->order_date = Carbon::now()->format('Y-m-d h:i:s');
        self::$order->save();
    }

    /**
     * removes all items from the order to prevent duplicate entries
     *
     * @return void
     */
    private static function refreshProducts()
    {
        self::$order->products()->detach();
    }
}
