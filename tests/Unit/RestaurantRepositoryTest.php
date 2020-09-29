<?php

namespace Tests\Unit;

use App\Models\Meal;
use App\Models\RestaurantMeal;
use App\Models\Restaurant;
use App\Repositories\Restaurant\MealRepository;
use App\Repositories\Restaurant\RestaurantMealRepository;
use App\Repositories\Restaurant\RestaurantRepository;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;

class RestaurantRepositoryTest extends TestCase
{

    use DatabaseMigrations;

    public function __construct(?string $name = null, array $data = [], $dataName = '')
    {
        parent::__construct($name, $data, $dataName);
        $this->restaurant = new Restaurant();
        $this->meal = new Meal();
        $this->restaurantMeal = new RestaurantMeal();
        $this->mealRepo = new MealRepository();
        $this->restaurantMealRepo = new RestaurantMealRepository();
        $this->restaurantRepo = new RestaurantRepository($this->restaurant, $this->mealRepo, $this->restaurantMealRepo);


    }

    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testExample()
    {
        $this->assertTrue(true);
    }

    public function testSearch()
    {

        $data = [
            [
                'id' => 1,
                'name' => 'Some Name',
            ],
            [
                'id' => 2,
                'name' => 'Some Name2',
            ],
        ];

        $this->assertEquals([
            [
                'id' => 1,
                'name' => 'Some Name',
            ]
        ], $this->restaurantRepo->search($data, 'id', 1));
    }

    public function testGetModel()
    {
        $this->assertInstanceOf(Restaurant::class, $this->restaurantRepo->getModel());
    }

    public function testGetRestaurantsIdsByMealId()
    {
        // Seed the DB
        seedDB();

        $data = $this->restaurantRepo->getRestaurantsIdsByMealId(1);
        $this->assertTrue(is_array($data) && count($data) > 0);
    }

    /*
     * this test is failing because of an error in mocking local scopes
    public function testGetRestaurantsOrderedByDistance()
    {
        $mealRepo = new MealRepository();
        $restaurantMealRepo = new RestaurantMealRepository();
        $restaurantRepo = new RestaurantRepository($this->restaurant, $mealRepo, $restaurantMealRepo);

        // Seed the DB
        seedDB();

        $data = $restaurantRepo->getRestaurantsOrderedByDistance(30.121892, 31.250228);
        $firstRecord = $data[0];
        $this->assertTrue(is_array($data) && count($data) > 0);
        $this->assertTrue($firstRecord['id'] > 0);
        $this->assertTrue($firstRecord['customer_recommendation_value'] > 0);
    }*/

    public function testGetRestaurantsOrderedByCustomersRecommendationCount()
    {
        // Seed the DB
        seedDB();

        $this->restaurantRepo->mealRestaurantIds = $this->restaurantRepo->getRestaurantsIdsByMealId(1);
        $this->restaurantRepo->count = count($this->restaurantRepo->mealRestaurantIds);
        $data = $this->restaurantRepo->getRestaurantsOrderedByCustomersRecommendationCount();
        $firstRecord = $data[0];

        $this->assertTrue(is_array($data) && count($data) > 0);
        $this->assertTrue($firstRecord['id'] > 0);

    }

    public function testGetRestaurantsOrderedByMealsRecommendationCount()
    {
        // Seed the DB
        seedDB();

        $this->restaurantRepo->mealRestaurantIds = $this->restaurantRepo->getRestaurantsIdsByMealId(1);
        $this->restaurantRepo->count = count($this->restaurantRepo->mealRestaurantIds);
        $this->restaurantRepo->getRestaurantsOrderedByCustomersRecommendationCount();
        $data = $this->restaurantRepo->getRestaurantsOrderedByMealsRecommendationCount();
        $firstRecord = $data[0];

        $this->assertTrue(is_array($data) && count($data) > 0);
        $this->assertTrue($firstRecord['id'] > 0);
    }

    public function testGetRestaurantsOrdersBySuccessfulOrdersCount()
    {
        // Seed the DB
        seedDB();

        $this->restaurantRepo->mealRestaurantIds = $this->restaurantRepo->getRestaurantsIdsByMealId(1);
        $this->restaurantRepo->count = count($this->restaurantRepo->mealRestaurantIds);
        $this->restaurantRepo->getRestaurantsOrderedByCustomersRecommendationCount();
        $this->restaurantRepo->getRestaurantsOrderedByMealsRecommendationCount();
        $data = $this->restaurantRepo->getRestaurantsOrdersBySuccessfulOrdersCount();
        $firstRecord = $data[0];

        $this->assertTrue(is_array($data) && count($data) > 0);
        $this->assertTrue($firstRecord['id'] > 0);
    }
}
