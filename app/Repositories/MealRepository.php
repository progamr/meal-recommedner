<?php


namespace App\Repositories;


use App\Models\Meal;

class MealRepository
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
        return $this->model->where($field, $value)->first();
    }
}
