<?php

namespace App\Repositories;

class BaseRepository
{
    private $model;
    public function __construct($model)
    {
        $this->model = $model;
    }

    public function getById($id)
    {
        return $this->model->find($id);
    }

    public function create($attribute = [])
    {
        return $this->model->create($attribute);
    }

    public function update($id, $attribute)
    {
        $model = $this->getById($id);
        $model->update($attribute);

        return $model;
    }
}
