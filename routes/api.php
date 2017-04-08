<?php

Route::group(["prefix" => "meals"], function() {
    Route::get("/", "MealsController@index");
    Route::get("/random", "MealsController@random");

    Route::post("/", "MealsController@store");
});
