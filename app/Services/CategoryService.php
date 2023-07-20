<?php

namespace App\Services;

use App\Repositories\CategoryRepository;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Str;

class CategoryService
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }

    public function getAllCategory()
    {
        return $this->categoryRepository->getCategories();
    }

    public function getParentCategories()
    {
        return $this->categoryRepository->getParentCategories();
    }

    public function store($request)
    {
        try {
            DB::Begintransaction();
            $category = $this->categoryRepository->create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'parent_id' => $request->parent_id,
                'is_active' => $request->is_active ? 1 : 0,
            ]);
            DB::commit();

            return Redirect::route('categories.index')->with('success', 'Created Category Successfully!');
        } catch (\Exception $e) {
            DB::rollBack();

            return Redirect::back()->withErrors(['create' => 'Something Wrong!'])->withInput();
        }
    }
}
