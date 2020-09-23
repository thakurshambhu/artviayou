<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\ShippingAddress;

class ShippingAddressRepository implements RepositoryInterface
{
    private $model;

    public function __construct(ShippingAddress $ShippingAddress)
    {
        $this->model = $ShippingAddress;
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

        if (!empty($conditions['order_id'])) {
            $query->where('order_id', $conditions['order_id']);
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