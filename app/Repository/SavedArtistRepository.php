<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\SavedArtist;

class SavedArtistRepository implements RepositoryInterface
{
    private $model;

    public function __construct(SavedArtist $SavedArtist)
    {
        $this->model = $SavedArtist;
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
        if (!empty($conditions['guest_id'])) {
            $query->where('guest_id', $conditions['guest_id']);
        }
        if (!empty($conditions['user_id'])) {
            $query->where('user_id', $conditions['user_id']);
        }
        if (!empty($conditions['artist_id'])) {
            $query->where('artist_id', $conditions['artist_id']);
        }
        if (!empty($conditions['status'])) {
            $query->where('status', $conditions['status']);
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