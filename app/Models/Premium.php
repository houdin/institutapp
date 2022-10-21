<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Premium extends Model
{
    use HasFactory;

    public $table = "premium";

    protected $appends = ['premium_list'];

    public function getPremiumListAttribute()
    {
        $content = substr($this->content, 0, -1);
        return explode('.', $content);
    }
}
