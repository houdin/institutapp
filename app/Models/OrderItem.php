<?php

namespace App\Models;


use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class OrderItem extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    //    public function formation(){
    //        return $this->belongsTo(Formation::class);
    //    }
    //
    //

    public function formation()
    {
        return $this->hasManyThrough(Formation::class, User::class);
    }

    public function product()
    {
        return $this->belongsToMany(Product::class)->withPivot('order_id', 'product_id', 'quantity');
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }
}
