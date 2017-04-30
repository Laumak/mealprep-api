<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Week extends Model
{
    protected $guarded = [];

    public function days() {
        return $this->hasMany(Day::class);
    }

    public function createDays() {
        $weekDays = array(
            "monday", "tuesday", "wednesday",
            "thursday", "friday", "saturday", "sunday"
        );

        foreach($weekDays as $day) {
            $this->days()->create([ "name" => $day ]);
        }
    }
}
