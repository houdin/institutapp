<?php
/*
|--------------------------------------------------------------------------
| CartTransformer.php
|--------------------------------------------------------------------------
| Created by Shawn Legge
| This class is responsible for receiving a collection of shopping cart
| items and returning an array of product information
*/

namespace App\Library\Transformer;

use App\Models\Bundle;
use Illuminate\Support\Str;

use App\Models\Formation;
use App\Models\Premium;
use App\Models\Product;
use App\Models\Tax;
use App\Models\Tutorial;
use Cart;

class CartTransformer
{

    protected $type;

    /**
     * get an array of shopping cart information and
     *
     * @return array
     */
    public static function transform()
    {
        $array['information'] = self::getTotal();
        $array['products'] = self::getProducts();
        return $array;
    }

    /**
     * set total amount
     *
     * @return array
     */
    protected static function getTotal()
    {
        return [
            // 'sub_total' => number_format(CartProvider::instance()->subtotal, 2, '.', ' '),
            'sub_total' => number_format(Cart::getSubTotal(), 2, '.', ' '),
            'total' => number_format(Cart::getTotal(), 2, '.', ' '),
            'taxes' => self::ApplyTax(),
            'count' =>  Cart::getContent()->count()
        ];
    }

    /**
     * gets all product information by querying each product and returning a product transformer
     *
     * @return array
     */
    protected static function getProducts()
    {
        $array = [];
        if (Cart::getContent()->count() > 0) {
            foreach (Cart::getContent() as $item) {
                $array[] = [
                    'id' => $item->id,
                    'title' => $item->name,
                    'price' => number_format($item->price, 2, '.', ' '),
                    'taxes' => number_format($item->taxAmount, 2, '.', ' '),
                    'total' => number_format($item->getPriceSum(), 2, '.', ' '),
                    'quantity' => $item->quantity,
                    'weight' => number_format($item->attributes->weight, 2),
                    'image' => self::getImage(('\App\Models\\' . Str::ucfirst($item->attributes['type']))::findOrFail($item->id)),
                    'attributes' => $item->attributes
                ];
            }
        }
        return $array;
    }

    /**
     * returns the image path
     *
     * @param Product $product
     * @return string
     */
    private static function getImage($product)
    {
        return $product->image->url;
    }


    private static function applyTax()
    {
        //Apply Conditions on Cart
        $taxes = Tax::where('status', '=', 1)->get();
        Cart::removeConditionsByType('tax');
        if ($taxes != null) {
            $taxData = [];
            foreach ($taxes as $tax) {
                $total = Cart::getTotal();
                $taxData[] = ['name' => '+' . $tax->rate . '% ' . $tax->name, 'amount' => $total * $tax->rate / 100];
            }

            $condition = new \Darryldecode\Cart\CartCondition(array(
                'name' => 'Tax',
                'type' => 'tax',
                'target' => 'total', // this condition will be applied to cart's subtotal when getSubTotal() is called.
                'value' => $taxes->sum('rate') . '%',
                'order' => 2
            ));
            Cart::condition($condition);
            return $taxData;
        }
    }
}
