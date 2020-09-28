<?php


namespace App\Repositories\Restaurant;


use App\Models\Meal;
use App\Repositories\Contracts\MealRepositoryInterface as MealRepositoryContract;
use App\Repositories\EloquentRepository;

class MealRepository extends EloquentRepository implements MealRepositoryContract
{
    public $model;

    public function __construct()
    {
        $this->model = new Meal();
    }

    /**
     * @param $field
     * @param $value
     * @return mixed
     */
    public function findBy($field, $value)
    {
        return $this->getModel()->where($field, $value)->first();
    }
}
