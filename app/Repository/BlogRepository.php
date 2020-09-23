<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\Blog;

class BlogRepository implements RepositoryInterface
{
    private $model;

    public function __construct(Blog $Blog)
    {
        $this->model = $Blog;
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

        if (!empty($conditions['is_active'])) {
            $query->where('is_active', $conditions['is_active']);
        }

        if (!empty($conditions['user_id'])) {
            $query->where('user_id', $conditions['user_id']);
        }

        if (!empty($conditions['is_deleted'])) {
            $query->where('is_deleted', $conditions['is_deleted']);
        }

        if (!empty($conditions['user_type'])) {
            $query->where('user_type', $conditions['user_type']);
        }

        if (!empty($conditions['except'])) {
            $query->where('id','<>',$conditions['except']);
        }

        if (!empty($withArr)) {
            $query->with($withArr);
        }

        $resultSet = $query->orderBy('created_at', 'desc')->take(5)->$method();

        if (!empty($resultSet) && $toArray) {
            $resultSet = $resultSet->toArray();
        }

        return $resultSet;
    }
}