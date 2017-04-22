<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Day extends Model
{
    protected $guarded = [];

    public function week() {
        return $this->belongsTo(Week::class);
    }

    public function lunch() {
        return $this->belongsToMany(Meal::class)->wherePivot('type', 'lunch');
    }

    public function dinner() {
        return $this->belongsToMany(Meal::class)->wherePivot('type', 'dinner');
    }

    public function getNameAttribute($value) {
        return ucfirst($value);
    }
}
