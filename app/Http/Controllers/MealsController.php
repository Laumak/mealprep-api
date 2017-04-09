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
        $meals = Meal::with("headerImage")
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
        //
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

    public function random() {
        $randomMeal = Meal::inRandomOrder()->with("headerImage")->with("images")->first();

        return response()->json([
            "meal" => $randomMeal,
        ], 200);
    }
}
