<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Day;

class DailyMealsController extends Controller
{
    public function update(Request $request, $id) {
        $mealID = $request["mealID"];
        $type   = $request["type"];

        $day = Day::whereId($id)->first();

        if($type === "lunch") {
            $day->lunch()->detach();
            $day->lunch()->attach([ $mealID => ["type" => $type] ]);
        }

        if($type === "dinner") {
            $day->dinner()->detach();
            $day->dinner()->attach([ $mealID => ["type" => $type] ]);
        }

        $updatedDay = Day::whereId($id)->with("lunch", "dinner")->first();

        return response()->json([
            "day" => $updatedDay
        ], 200);
    }

    public function dissoc($id, $type) {
        $day = Day::whereId($id)->first();

        $day->$type()->detach();

        $week = $day->week()->first();

        return response()->json([
            "week" => $week,
        ], 200);
    }
}
