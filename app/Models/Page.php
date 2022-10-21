<?php

namespace App\Models;

use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\File;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
	use HasFactory, Notifiable;
    use SoftDeletes;
    protected $appends = ['page_image'];
    protected $guarded = [];


    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($page) { // before delete() method call this
            if ($page->isForceDeleting()) {
                if (File::exists(public_path('/storage/uploads/' . $page->image))) {
                    File::delete(public_path('/storage/uploads/' . $page->image));
                }
            }
        });

    }


    public function getPageImageAttribute()
    {
        if ($this->image != null) {
            return url('storage/uploads/' . $this->image);
        }
        return NULL;
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
