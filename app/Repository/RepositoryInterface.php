<?php
namespace App\Repository;

interface RepositoryInterface
{
    public function getData($conditions, $method, $withArr = [],$toArray);

    public function createUpdateData($conditions, $parameters);
}