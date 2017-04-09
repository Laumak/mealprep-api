<?php

Route::group(["prefix" => "meals"], function() {
    Route::get("/", "MealsController@index");
    Route::post("/random", "MealsController@random");

    Route::post("/", "MealsController@store");

    Route::get("/{id}", "MealsController@show");
});
