<?php

Route::post("/register",     "AuthController@register");
Route::post("/authenticate", "AuthController@authenticate");

Route::group(["middleware" => "jwt.auth"], function() {
    Route::post("/checkAuthStatus",  "AuthController@checkAuthStatus");

    Route::group(["prefix" => "meals"], function() {
        Route::get("/", "MealsController@index");
        Route::post("/random", "MealsController@random");

        Route::post("/", "MealsController@store");
        Route::get("/{id}", "MealsController@show");
        Route::put("/{id}", "MealsController@update");
        Route::delete("/{id}", "MealsController@destroy");
    });

    Route::get("/week", "WeeksController@current");
    Route::get("/week/{number}/{year}", "WeeksController@show");

    Route::put("/dailyMeal/{id}", "DailyMealsController@update");
});
