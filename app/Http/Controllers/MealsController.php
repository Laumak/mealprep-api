<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

use App\Meal;

class MealsController extends Controller
{
    public function index()
    {
        $meals = Meal::with("headerImage")
                     ->with("images")
                     ->paginate(10);

        return response()->json([
            "meals" => $meals
        ], 200);
    }

    public function store(Request $request)
    {
        $path = null;

        if($request->hasFile("headerImage")) {
            $path = $request->file("headerImage")->store("headerImages");
        }

        $meal = Meal::create([
            "title"       => $request["title"],
            "url"         => $request["url"],
            "description" => $request["description"],
            "type"        => $request["type"],
            "header_url"  => $path
        ]);

        return response()->json([
            "meal" => $meal
        ], 201);
    }

    public function show($id)
    {
        $meal = Meal::whereId($id)->with("headerImage", "images")->first();

        return response()->json([
            "meal" => $meal,
        ], 200);
    }

    public function random(Request $request) {
        $type = $request["mealType"];

        if($type !== null) {
            $randomMeal = Meal::inRandomOrder()->whereType($type)->with("headerImage", "images")->first();
        } else {
            $randomMeal = Meal::inRandomOrder()->with("headerImage", "images")->first();
        }

        return response()->json([
            "meal" => $randomMeal,
        ], 200);
    }
}
