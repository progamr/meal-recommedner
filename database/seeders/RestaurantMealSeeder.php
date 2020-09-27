<?php

namespace Database\Seeders;

use App\Models\RestaurantMeal;
use Illuminate\Database\Seeder;

class RestaurantMealSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
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
    }
}
