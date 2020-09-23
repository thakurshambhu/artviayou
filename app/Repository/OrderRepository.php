<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\Order;

class OrderRepository implements RepositoryInterface
{
    private $model;

    public function __construct(Order $Order)
    {
        $this->model = $Order;
    }

    //To create and update data
    public function createUpdateData($condition, $parameters)
    {
        return $resultSet = $this->model->updateOrCreate($condition, $parameters);
    }

    //To create data
    public function createData($data){
        return $resultSet = $this->model->create($data);
    }

    //To fetch data
    public function getData($conditions, $method, $withArr = [],$toArray)
    {
        $query = $this->model->whereNotNull('id');

        if (!empty($conditions['id'])) {
            $query->where('id', $conditions['id']);
        }

        if (!empty($conditions['user_id'])) {
            $query->where('user_id', $conditions['user_id']);
        }

        if (!empty($conditions['artwork_id'])) {
            $query->where('artwork_id', $conditions['artwork_id']);
        }

        if (!empty($conditions['artist_id'])) {
            $query->where('artist_id', $conditions['artist_id']);
        }

        if (!empty($conditions['status'])) {
            $query->where('status', [0,$conditions['status']]);
        }

        if (!empty($conditions['artist_user_orders'])) {
            $query->where('user_id', $conditions['artist_user_orders'])
                  ->orWhere('artist_id', $conditions['artist_user_orders']);
        }

        if (!empty($withArr)) {
            $query->with($withArr);
        }

        $resultSet = $query->orderBy('created_at', 'desc')->$method();

        if (!empty($resultSet) && $toArray) {
            $resultSet = $resultSet->toArray();
        }

        return $resultSet;
    }
}