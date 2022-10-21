<?php

namespace App\Models;

use Carbon\Carbon;
use App\Models\Product;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Sale extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'product_id', 'start', 'finish', 'discount'
    ];

    /**
     * @param $query
     * @return Sale
     */
    public function scopeCurrent($query)
    {
        return $query->where('start', '<=', Carbon::now())
            ->where('finish', '>=', Carbon::now()->format('Y-m-d'));
    }


    /**
     * a sale has a single product
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
