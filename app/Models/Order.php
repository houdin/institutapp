<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'user_id',
        'reference_no',
        'amount',
        'payment_type',
        'status',
        'transaction',
        'remarks',
        'coupon_id',
        'total',
        'sub_total',
        'address_id',
        'taxes',
        'ship_date',
        'order_date',
        'shipped'
    ];
    protected $guarded = [];

    /**
     * formats the total into cents
     *
     * @return integer
     */
    public function formatTotalCents()
    {
        return number_format($this->total * 100, 0, '', '');
    }

    /**
     * gets a formatted string of the user order date
     *
     * @return string
     */
    public function formatOrderDate()
    {
        $date = \DateTime::createFromFormat('Y-m-d', $this->order_date);
        return $date->format('jS M, Y');
    }

    /**
     * gets a formatted string of the user ship date
     *
     * @return string | boolean
     */
    public function formatShipDate()
    {
        if (is_null($this->ship_date)) {
            return false;
        }
        $date = \DateTime::createFromFormat('Y-m-d', $this->ship_date);
        return $date->format('jS M, Y');
    }


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function invoice()
    {
        return $this->hasOne(Invoice::class);
    }

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }

    /**
     * an order has an address
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function address()
    {
        return $this->belongsTo(Address::class);
    }

    /**
     * does the order belong to the user
     *
     * @return bool
     */
    public function belongsToUser($userID)
    {
        return ((int)$this->user_id === (int)$userID);
    }

    /**
     * does the order exist
     *
     * @param $id
     * @return bool
     */
    public function exists($id)
    {
        return (is_null($this->find((int)$id))) ? false : true;
    }
}
