<?php


namespace App\Repositories\Restaurant;

use App\Repositories\Restaurant\MealRepository;
use App\Repositories\Restaurant\RestaurantMealRepository;
use App\Repositories\Contracts\RestaurantRepositoryInterface as RestaurantRepositoryContract;
use App\Models\Restaurant;
use App\Repositories\EloquentRepository;

class RestaurantRepository extends EloquentRepository implements RestaurantRepositoryContract
{
    private $mealRepository;
    private $restaurantMealRepository;
    public $model;
    private $count;
    private $mealRestaurantIds;
    private $totalRecommendationsCount = 3;
    private $distanceCriteriaWeight = 10;
    private $customersRestaurantRecommendationCriteriaWeight = 5;
    private $customersRestaurantMealRecommendationCriteriaWeight = 3;
    private $countOfSuccessfulOrdersCriteriaWeight = 5;

    public function __construct(Restaurant $model, MealRepository $mealRepository, RestaurantMealRepository $restaurantMealRepository)
    {
        $this->model = $model;
        $this->mealRepository = $mealRepository;
        $this->restaurantMealRepository = $restaurantMealRepository;
    }

    /**
     * @param array $filters
     * @return array
     */
    public function getRecommendations(array $filters): array
    {
        $meal = $this->mealRepository->findBy('name', $filters['meal_name']);

        if(! $meal)
            return [];

        $this->mealRestaurantIds = $this->getRestaurantsIdsByMealId($meal->id);
        $this->count = count($this->mealRestaurantIds);

        $distanceRestaurantsRecommendations = $this->getRestaurantsOrderedByDistance($filters['latitude'], $filters['longitude']);
        $restaurantBasedONCustomersRecommendations = $this->getRestaurantsOrderedByCustomersRecommendationCount();
        $restaurantBasedONMealsRecommendations = $this->getRestaurantsOrderedByMealsRecommendationCount();
        $restaurantBasedONOrdersCount = $this->getRestaurantsOrdersBySuccessfulOrdersCount();

        $result = [];       // final recommendation -result
        $restaurant = [];   // will hold each restaurant data in the loop
        foreach ($this->mealRestaurantIds as $restaurantId) {
            $item = $this->search($restaurantBasedONCustomersRecommendations, 'id', $restaurantId);
            $restaurant['id'] = $restaurantId;
            $restaurant['name'] = $item[0]['name'];
            $rank = $item[0]['customer_recommendation_value'];

            $item = $this->search($restaurantBasedONOrdersCount, 'id', $restaurantId);
            if($item)
                $rank += $item[0]['successful_orders_value'];

            $item = $this->search($distanceRestaurantsRecommendations, 'id', $restaurantId);
            if($item)
                $rank += $item[0]['distance_value'];

            $item = $this->search($restaurantBasedONMealsRecommendations, 'id', $restaurantId);
            if($item)
                $rank += $item[0]['customer_meal_recommendations_value'];

            $restaurant['rank'] = $rank;
            $result[] = $restaurant;
        }

        // Sort the resulting restaurants array by rank
        $columns = array_column($result, 'rank');
        array_multisort($columns, SORT_DESC, $result);

        // Take only the first 3 restaurants as a final result
        $result = array_slice ($result, 0, $this->totalRecommendationsCount);
        return $result;
    }

    function search($array, $key, $value) {
        $results = array();

        if (is_array($array)) {

            if (isset($array[$key]) && $array[$key] == $value) {
                $results[] = $array;
            }

            // Iterate for each element in array
            foreach ($array as $subarray) {

                $results = array_merge($results,
                    $this->search($subarray, $key, $value));
            }
        }

        return $results;
    }

    private function getOrderBy(string $column, string $direction ='asc', int $offset = 0, int $limit = 10)
    {
        return $this->getModel()
            ->orderBy($column, $direction)
            ->offset($offset)
            ->take($limit);
    }

    private function getRestaurantsIdsByMealId($mealId)
    {
        return $this->restaurantMealRepository->getModel()
            ->where('meal_id', $mealId)
            ->orderBy('meal_recommendations_count', 'desc')
            ->pluck('restaurant_id')
            ->toArray();

    }

    private function getRestaurantsOrderedByDistance($latitude, $longitude)
    {
        $restaurants = [];
        for($offset=0; $offset <= $this->count; $offset+=1000) {
            $result = $this->getModel()
                ->nearBy($this->model, $latitude, $longitude)
                ->offset($offset)
                ->take(1000)
                ->whereIn('id', $this->mealRestaurantIds)
                ->get(['id', 'name'])
                ->toArray();
            $data = [];

            for($i=$offset;$i < count($result);$i++) {
                $result[$i]['distance_value'] = $this->distanceCriteriaWeight / ($i + 1);
                $data[] = $result[$i];
            }

            $restaurants = array_merge($restaurants,  $data);
        }

        return $restaurants;
    }

    private function getRestaurantsOrderedByCustomersRecommendationCount()
    {
        $restaurants = [];
        for($offset=0; $offset < $this->count; $offset+=1000) {
            $result = $this->getOrderBy('customers_recommendations_count', 'desc', $offset, 1000)
                ->whereIn('id', $this->mealRestaurantIds)
                ->get(['id', 'name'])
                ->toArray();
            $data = [];

            for($i=$offset;$i < count($result);$i++) {
                $result[$i]['customer_recommendation_value'] = $this->customersRestaurantRecommendationCriteriaWeight / ($i + 1);
                $data[] = $result[$i];
            }

            $restaurants = array_merge($restaurants,  $data);
        }

        return $restaurants;
    }

    private function getRestaurantsOrderedByMealsRecommendationCount()
    {
        $restaurants = [];

        for($i=0; $i < count($this->mealRestaurantIds); $i++) {
            $restaurants[][] = [
                'id' => $this->mealRestaurantIds[$i],
                'customer_meal_recommendations_value' => $this->customersRestaurantMealRecommendationCriteriaWeight / ($i + 1)
            ];
        }

        return $restaurants;
    }

    private function getRestaurantsOrdersBySuccessfulOrdersCount()
    {
        $restaurants = [];
        for($offset=0; $offset < $this->count; $offset+=1000) {
            $result = $this->getOrderBy('successful_orders_count', 'desc', $offset, 1000)
                ->whereIn('id', $this->mealRestaurantIds)
                ->get(['id', 'name'])
                ->toArray();
            $data = [];

            for($i=$offset; $i < count($result); $i++) {
                $result[$i]['successful_orders_value'] = $this->countOfSuccessfulOrdersCriteriaWeight / ($i + 1);
                $data[] = $result[$i];
            }

            $restaurants = array_merge($restaurants,  $data);
        }

        return $restaurants;
    }
}
