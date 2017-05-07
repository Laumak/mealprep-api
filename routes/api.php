<?php

Route::post("/register",     "AuthController@register");
Route::post("/authenticate", "AuthController@authenticate");

Route::get("/meals",                 "MealsController@index");
Route::get("/meals/all",             "MealsController@all");
Route::get("/meals/random/{type?}",  "MealsController@random");
Route::get("/meals/{id}",            "MealsController@show");

Route::group(["middleware" => "jwt.auth"], function() {
    Route::post("/checkAuthStatus",  "AuthController@checkAuthStatus");

    Route::post("/meals", "MealsController@store");
    Route::put("/meals/{id}", "MealsController@update");
    Route::delete("/meals/{id}", "MealsController@destroy");

    Route::get("/week", "WeeksController@current");
    Route::get("/week/{number}/{year}", "WeeksController@show");

    Route::put("/dailyMeal/{id}", "DailyMealsController@update");
});
