<?php

namespace App\Models;

use App\Models\Traits\DistanceSortable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    use HasFactory;
    /*
     * used for sorting restaurants - or any other Model in the future -
     * by long and lat.
     */
    use DistanceSortable;

    /**
     * The restaurants that belong to the meal.
     */
    public function meals()
    {
        return $this->belongsToMany('App\Models\Meal', 'restaurant_meal');
    }
}
