<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Carbon\Carbon;

use App\Week;

class WeeksController extends Controller
{
    public function current() {
        $today = Carbon::now();

        $currentWeek = $today->weekOfYear;
        $currentYear = $today->year;

        $week = Week::where(["number" => $currentWeek, "year" => $currentYear])
                    ->with("days.lunch", "days.dinner")
                    ->first();

        return response()->json([
            "week" => $week,
        ], 200);
    }
}
