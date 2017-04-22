<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meal extends Model
{
    protected $fillable = [
        "title", "description", "url", "type",
    ];

    public function headerImage() {
        return $this->hasOne(Image::class);
    }

    public function images() {
        return $this->hasMany(Image::class);
    }

    public function days() {
        return $this->belongsToMany(Day::class);
    }
}
