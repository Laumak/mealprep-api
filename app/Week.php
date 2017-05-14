<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Week extends Model
{
    protected $guarded = [];

    public function days() {
        return $this->hasMany(Day::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function createDays() {
        $days = array(
            "monday",
            "tuesday",
            "wednesday",
            "thursday",
            "friday",
            "saturday",
            "sunday",
        );

        foreach($days as $index => $day) {
            $dt = $this->firstDayOfWeek()->addDays($index);

            $this->days()->create([
                "date" => $dt->toDateTimeString(),
            ]);
        }
    }

    private function firstDayOfWeek() {
        $now = Carbon::now();

        $currentWeekNumber = $now->weekOfYear;
        $weekNumber        = $this->number;

        $firstDayOfWeek;

        if($currentWeekNumber > $weekNumber) {
            $firstDayOfWeek = $now->subWeeks($currentWeekNumber - $weekNumber)->startOfWeek();
        } else if($currentWeekNumber < $weekNumber) {
            $firstDayOfWeek = $now->addWeeks($weekNumber - $currentWeekNumber)->startOfWeek();
        } else {
            $firstDayOfWeek = $now->startOfWeek();
        }

        return $firstDayOfWeek;
    }
}
