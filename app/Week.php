<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $guarded = [];

    public function days() {
        return $this->hasMany(Day::class);
    }
}
