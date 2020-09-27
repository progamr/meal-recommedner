<?php

namespace Database\Factories;

use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

class RestaurantFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Restaurant::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name'                              => $this->faker->company,
            'customers_recommendations_count'   => $this->faker->biasedNumberBetween(1000, 100000),
            'successful_orders_count'           => $this->faker->biasedNumberBetween(10, 100000),
            'latitude'                          => $this->faker->latitude($min = -90, $max = 90),
            'longitude'                         => $this->faker->longitude($min = -180, $max = 180)
        ];
    }
}
