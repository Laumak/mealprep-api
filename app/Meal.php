<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        "title", "description", "url", "type", "header_url",
    ];

    public function headerImage() {
        return $this->hasOne(HeaderImage::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }
}
