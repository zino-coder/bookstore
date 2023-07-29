<?php

namespace App\Repositories;

use App\Models\Category;

class CategoryRepository extends BaseRepository
{
    private $model;

    public function __construct(Category $model)
    {
        $this->model = $model;
        parent::__construct($model);
    }

    public function getCategories($page)
    {
        return $this->model
            ->with(['parentCategory'])
            ->paginate(10, '*', 'p', $page);
    }

    public function getParentCategories()
    {
        return $this->model->where('parent_id', 0)->get();
    }
}
