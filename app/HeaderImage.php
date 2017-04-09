<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HeaderImage extends Model
{
    protected $fillable = [
        "url"
    ];

    public function Meal() {
        return $this->belongsTo(Meal::class);
    }
}
