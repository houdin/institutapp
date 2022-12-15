<?php

namespace App\Models;

use App\Models\Blog;
use App\Models\Auth\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Certificate extends Model
{
    use HasFactory, Notifiable;

    protected $guarded = [];
    protected $appends = ['certificate_link'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function formation()
    {
        return $this->belongsTo(Formation::class);
    }

    public function getCertificateLinkAttribute()
    {
        if ($this->url != null) {
            return url('storage/certificates/' . $this->url);
        }
        return NULL;
    }
}
