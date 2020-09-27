<?php

use Illuminate\Support\Facades\Route;

/**
 * Main route of the app that render the recommendation form.
 */
Route::get('/', function () {
    return view('meal-recommendation-form');
});

/**
 * find recommendations of restaurants based on meal name and user location.
 */
Route::post('find-restaurants', [\App\Http\Controllers\RestaurantsController::class, 'recommend']);
