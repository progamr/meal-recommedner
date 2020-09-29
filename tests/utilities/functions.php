<?php

use App\Models\Meal;
use App\Models\Restaurant;
use App\Models\RestaurantMeal;

function SeedDB() {
    $meals = ['Fried Chicken', 'Kofta', 'Koshary', 'Burger', 'Fish', 'Shawerma'];
    for ($i=0;$i<6;$i++)
        Meal::create(['name' => $meals[$i]]);


    $faker = new \Faker\Generator();
    $faker->addProvider(new \Faker\Provider\Biased($faker));
//
    for ($restaurantId=1;$restaurantId <= 10;$restaurantId++) {
        for ($mealId=1;$mealId <= 6;$mealId++) {
            RestaurantMeal::create([
                'restaurant_id'                 => $restaurantId,
                'meal_id'                       => $mealId,
                'meal_recommendations_count'    => $faker->biasedNumberBetween(10, 100000),
            ]);
        }
    }

    Restaurant::factory(10)->create();
}
