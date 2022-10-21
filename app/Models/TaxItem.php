<?php

namespace App\Models;


use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TaxItem extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    //    public function formation(){
    //        return $this->belongsTo(Formation::class);
    //    }
    //
    //    public function bundle(){
    //        return $this->belongsTo(Bundle::class);
    //    }
    //

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function item()
    {
        return $this->morphTo();
    }

    public function tax()
    {
        return $this->belongsTo(Tax::class);
    }
}
