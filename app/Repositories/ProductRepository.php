<?php

namespace App\Repositories;

use App\Models\Product;

class ProductRepository extends BaseRepository
{
    public function __construct(readonly Product $model)
    {
        parent::__construct($this->model);
    }

    public function getProducts($request)
    {
        $query = $this->model->newQuery();

        if ($request->s) {
            $query->where('name', 'link', "%$request->s%")
                ->orWhere('description', 'link', "%$request->s")
                ->orWhere('content', 'link', "%$request->s");
        }

        if ($request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->status) {
            $query->where($request->status, 1);
        }

        switch ($request->sort) {
            case 'name_asc':
                $query->orderBy('name', 'ASC');
                break;
            case 'name_desc':
                $query->orderBy('name', 'DESC');
                break;
            case 'price_asc':
                $query->orderBy('price', 'ASC');
                break;
            case 'price_desc':
                $query->orderBy('price', 'DESC');
                break;
        }
        $page = $request->page ?? 1;

        return $query->paginate(10, '*', 'page', $page);
    }

    public function getProductByAttribute($limit = 5, $attr = null, $value = null)
    {
        $query = $this->model->newQuery();

        if (!empty($attr)) {
            $query = $query->where($attr, $value);
        }

        $query = $query->limit($limit)->orderBy('created_at', 'DESC');

        return $query->get();
    }
}
