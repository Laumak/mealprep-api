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
        $meals = Meal::with("headerImage")->with("images")->get();

        return response()->json([
            "data" => [
                "meals" => $meals
            ]
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
            "description" => $request["description"],
        ]);

        return response()->json([
            "data" => $meal
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
        //
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
        $randomMeal = Meal::inRandomOrder()->first();

        return response()->json([
            "meal" => $randomMeal,
        ], 200);
    }
}
