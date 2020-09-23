<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\Message;

class MessageRepository implements RepositoryInterface
{
    private $model;

    public function __construct(Message $Message)
    {
        $this->model = $Message;
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

        if (!empty($conditions['from_user_id'])) {
            $query->where('from_user_id', $conditions['from_user_id']);
        }

        if (!empty($conditions['to_user_id'])) {
            $query->where('to_user_id', $conditions['to_user_id']);
        }

        if (!empty($conditions['read_status'])) {
            $query->where('read_status', $conditions['read_status']);
        }

        if (!empty($conditions['to_user_id'])) {
            $query->where('to_user_id', $conditions['to_user_id']);
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