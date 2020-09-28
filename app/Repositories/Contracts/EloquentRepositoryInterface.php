<?php


namespace App\Repositories\Contracts;


interface EloquentRepositoryInterface
{
    /**
     * getModel.
     *
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function getModel();
}
