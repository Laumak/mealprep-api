<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $fillable = [
        "url", "title", "description"
    ];

    public function meal() {
        return $this->belongsTo(Meal::class);
    }
}
