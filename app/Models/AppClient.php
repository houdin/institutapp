<?php

namespace App\Models;

use App\Scopes\AppScope;
use App\Models\OauthClient;
use App\Helpers\AppResolver;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class AppClient extends Model
{
    use HasFactory, Notifiable;

    public function client(){
        return $this->belongsTo(OauthClient::class,'client_id');
    }
    protected static function boot()
    {
        parent::boot();

        static::addGlobalScope(new AppScope( new AppResolver()));
    }
}
