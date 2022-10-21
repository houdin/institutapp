<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Address extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'address', 'postal_code', 'state_id', 'city_id'
    ];

    /**
     * gets the full address with the city and state
     *
     * @param $query
     * @param $id
     * @return mixed
     */
    public function scopeFull($query, $id)
    {
        return $query->where('id', $id)
            ->with('state')
            ->first();
    }

    /**
     * An address will have one state
     *
     * @return BelongsTo
     */
    public function state()
    {
        return $this->belongsTo(State::class);
    }

    /**
     * did the query return a result
     *
     * @return bool
     */
    public function hasResult()
    {
        return (isset($this->id));
    }
}
