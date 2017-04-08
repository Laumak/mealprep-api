<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        "title", "description"
    ];

    public function headerImage() {
        return $this->hasOne(Image::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }
}
