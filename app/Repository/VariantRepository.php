<?php
namespace App\Repository;

use App\Repository\RepositoryInterface;
use App\Variant;

class VariantRepository implements RepositoryInterface
{
    private $model;

    public function __construct(Variant $Variant)
    {
        $this->model = $Variant;
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

        if (!empty($conditions['artwork_id'])) {
            $query->where('artwork_id', $conditions['artwork_id']);
        }

        if (!empty($conditions['height'])) {
            $query->whereBetween('height', [0,$conditions['height']]);
        }

        if (!empty($conditions['width'])) {
            $query->whereBetween('width', [0,$conditions['width']]);
        }

        if (!empty($conditions['price'])) {
            $query->whereBetween('price', [0,$conditions['price']]);
        }

        if (!empty($conditions['variant_type'])) {
            $query->whereIn('variant_type', $conditions['variant_type']);
        }

        if (!empty($conditions['variant_id'])) {
            $query->whereNotIn('id', $conditions['variant_id']);
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