<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\Category;

class CategoryRepository implements RepositoryInterface
{
    private $model;

    public function __construct(Category $Category)
    {
        $this->model = $Category;
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

        if (!empty($conditions['is_deleted'])) {
            $query->where('is_deleted', $conditions['is_deleted']);
        }
        if (!empty($conditions['is_active'])) {
            $query->where('is_active', $conditions['is_active']);
        }

        if (!empty($conditions['name'])) {
            $query->where('name', $conditions['name']);
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