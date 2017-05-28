<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Storage;

class Image extends Model
{
    protected $fillable = [
        "url", "title", "description"
    ];

    public function meal() {
        return $this->belongsTo(Meal::class);
    }

    public function getUrlAttribute($value) {
        return Storage::disk("s3")->url($value);
    }
}
