<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\User;

class UserRepository implements RepositoryInterface
{
    private $model;

    public function __construct(User $User)
    {
        $this->model = $User;
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

        if (!empty($conditions['user_name'])) {
            $query->where('user_name', $conditions['user_name']);
        }

        if (!empty($conditions['role'])) {
            $query->where('role', $conditions['role']);
        }

        if (!empty($conditions['is_featured'])) {
            $query->where('is_featured', $conditions['is_featured']);
        }

        if (!empty($conditions['filter_key'])) {
            $query->where('first_name', 'like', '%'.$conditions['filter_key'].'%')
                  ->orWhere('last_name', 'like', '%'.$conditions['filter_key'].'%');
        }

        if (!empty($withArr)) {
            $query->with($withArr);
        }

        if(!empty($conditions['page'])){
            $resultSet = $query->orderBy('created_at', 'desc')->$method($conditions['page']);
        }else{
            $resultSet = $query->orderBy('created_at', 'desc')->$method();
        }

        if (!empty($resultSet) && $toArray) {
            $resultSet = $resultSet->toArray();
        }

        return $resultSet;
    }
}