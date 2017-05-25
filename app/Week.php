<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use Carbon\Carbon;

class Week extends Model
{
    protected $guarded = [];

    protected static function boot() {
        parent::boot();

        // When a week is created, also create the associated days.
        static::created(function($week) {
            $week->createDays();
        });
    }

    public function days() {
        return $this->hasMany(Day::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    private function createDays() {
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
