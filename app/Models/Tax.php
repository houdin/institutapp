<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Tax extends Model
{
    use HasFactory, Notifiable;
    protected $guarded = [];

    protected $fillable = [
        'name', 'amount', 'rate', 'description'
    ];

    protected $hidden = [
        'created_at', 'updated_at'
    ];

    public function items()
    {
        return $this->hasMany(TaxItem::class);
    }
}
