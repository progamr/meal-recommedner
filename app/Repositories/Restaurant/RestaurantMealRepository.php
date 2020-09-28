<?php


namespace App\Repositories\Restaurant;


use App\Models\RestaurantMeal;
use App\Repositories\Contracts\RestaurantMealRepositoryInterface as RestaurantMealRepositoryContract;
use App\Repositories\EloquentRepository;

class RestaurantMealRepository extends EloquentRepository implements RestaurantMealRepositoryContract
{
    public $model;

    public function __construct()
    {
        $this->model = new RestaurantMeal();
    }
}
