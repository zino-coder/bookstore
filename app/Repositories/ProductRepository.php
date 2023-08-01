<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(readonly Product $model)
    {
        parent::__construct($this->model);
    }

    public function getProducts()
    {
        return $this->model->paginate(10);
    }
}
