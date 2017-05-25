<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use JWTAuth;
use Carbon\Carbon;

use App\User;
use App\Week;

class WeeksController extends Controller
{
    public function store($week, $year) {
        $user = JWTAuth::parseToken()->authenticate();

        $week = $user->weeks()->create([
            "number" => $week,
            "year" => $year
        ]);

        return $week;
    }

    public function show($number, $year) {
        $new = false;

        $week = Week::where(["number" => $number, "year" => $year])
                    ->with("days.lunch", "days.dinner")
                    ->first();

        if(!$week) {
            $new = true;
            $newWeek = $this->store($number, $year);

            $week = Week::whereId($newWeek->id)
                    ->with("days.lunch", "days.dinner")
                    ->first();
        }

        $this->createAdjacentWeeks($week, $year);

        return response()->json([
            "new"  => $new,
            "week" => $week,
        ], 200);
    }

    public function current() {
        $new = false;

        $today = Carbon::now();
        $currentWeek = $today->weekOfYear;
        $currentYear = $today->year;

        $week = Week::where(["number" => $currentWeek, "year" => $currentYear])
                    ->with("days.lunch", "days.dinner")
                    ->first();

        if(!$week) {
            $new = true;
            $newWeek = $this->store($currentWeek, $currentYear);

            $week = Week::whereId($newWeek->id)
                    ->with("days.lunch", "days.dinner")
                    ->first();
        }

        $this->createAdjacentWeeks($week, $currentYear);

        return response()->json([
            "week" => $week,
            "new"  => $new,
        ], 200);
    }

    private function createAdjacentWeeks($week, $currentYear) {
        $user = JWTAuth::parseToken()->authenticate();

        $prevWeek = Week::whereNumber($week->number - 1)->first();
        $nextWeek = Week::whereNumber($week->number + 1)->first();

        if(!$prevWeek) {
            $prevWeek = $user->weeks()->create([
                "number" => $week->number - 1,
                "year" => $currentYear
            ]);
        }

        if(!$nextWeek) {
            $nextWeek = $user->weeks()->create([
                "number" => $week->number + 1,
                "year" => $currentYear
            ]);
        }
    }
}
