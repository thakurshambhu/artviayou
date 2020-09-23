<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\RequestComission;

class RequestComissionRepository implements RepositoryInterface
{
    private $model;

    public function __construct(RequestComission $RequestComission)
    {
        $this->model = $RequestComission;
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
            $query->where('request_status', $conditions['request_status']);
        }
        if (!empty($conditions['artist_id'])) {
            $query->where('artist_id', $conditions['artist_id']);
        }
        // if ($conditions['request_status']) {
        // }

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