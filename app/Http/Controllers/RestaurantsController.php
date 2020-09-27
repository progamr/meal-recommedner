<?php

namespace App\Http\Controllers;

use App\Http\Requests\GetRestaurantsRecommendation;
use App\Repositories\RestaurantsRepository;

/***
 * Class RestaurantsController
 * @package App\Http\Controllers
 */
class RestaurantsController extends Controller
{
    /**
     * Get Restaurants recommendations based on
     * meal name and user location.
     * @param GetRestaurantsRecommendation $request
     * @param RestaurantsRepository $repository
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function recommend(GetRestaurantsRecommendation $request, RestaurantsRepository $repository)
    {
        $restaurants = $repository->getRecommendations(
            [
                'latitude'  => $request->get('latitude'),
                'longitude' => $request->get('longitude'),
                'meal_name' => $request->get('meal_name')
            ]
        );

        return view('meal-recommendation-form')->with(['restaurants' => $restaurants]);
    }
}
