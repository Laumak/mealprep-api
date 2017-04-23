<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Meal;

class MealsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $meals = Meal::latest("updated_at")
                     ->with("headerImage")
                     ->with("images")
                     ->paginate(10);

        return response()->json([
            "meals" => $meals
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $meal = Meal::create([
            "title"       => $request["title"],
            "url"         => $request["url"],
            "description" => $request["description"],
            "type"        => $request["type"],
        ]);

        return response()->json([
            "meal" => $meal
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $meal = Meal::whereId($id)->with("headerImage")->with("images")->first();

        return response()->json([
            "meal" => $meal,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $meal = Meal::whereId($id)->update([
            "title"       => $request["meal"]["title"],
            "type"        => $request["meal"]["type"],
            "url"         => $request["meal"]["url"],
            "description" => $request["meal"]["description"],
        ]);

        $updatedMeal = Meal::whereId($id)->first();

        return response()->json([
            "meal" => $updatedMeal,
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function random(Request $request) {
        $type = $request["mealType"];

        if($type !== null) {
            $randomMeal = Meal::inRandomOrder()->whereType($type)->with("headerImage")->with("images")->first();
        } else {
            $randomMeal = Meal::inRandomOrder()->with("headerImage")->with("images")->first();
        }

        return response()->json([
            "meal" => $randomMeal,
        ], 200);
    }
}
