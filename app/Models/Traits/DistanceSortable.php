<?php


namespace App\Models\Traits;


trait DistanceSortable
{
    /**
     * Query nearby entities
     * @param $query
     * @param $latitude
     * @param $longitude
     * @param bool $sort
     * @param array $columns
     * @return mixed
     */
    public function scopeNearby(
        $query,
        $model,
        $latitude,
        $longitude
    )
    {
        $columns = 'id, name, customers_recommendations_count, successful_orders_count, latitude, longitude';
            return $query->addSelect(\DB::raw('ROUND(6371 * acos(cos(radians(' . $latitude . '))
        * cos(radians(latitude))
        * cos(radians(longitude) - radians(' . $longitude . '))
        + sin(radians(' . $latitude . '))
        * sin(radians(latitude))), 2) AS distance, '. $columns))
                ->orderBy('distance', 'desc');
    }
}
