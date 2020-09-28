<?php

namespace App\Repositories\Contracts;

/**
 * Interface RestaurantRepositoryInterface
 * @package App\Repositories\Contracts
 */
interface RestaurantRepositoryInterface {
    /**
     * @param array $filters
     * @return array
     */
    public function getRecommendations(array $filters): array;
}
