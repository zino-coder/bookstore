<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use Illuminate\Http\Request;
use App\Services\CategoryService;
use Illuminate\Routing\Route;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\URL;

class CategoryController extends Controller
{
    private $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories = $this->categoryService->getAllCategory(\request()->input('p', 1));

        return view('admin.category.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = $this->categoryService->getParentCategories();

        return view('admin.category.form', ['parentCategories' => $parentCategories]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreRequest $request)
    {
        $this->categoryService->store($request);

        return Redirect::route('categories.index')->with('success', 'Create Successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $category =  $this->categoryService->edit($id);
        $parentCategories = $this->categoryService->getParentCategories();

        return view('admin.category.form', compact(['category', 'parentCategories']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        return $this->categoryService->update($request, $id);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function changeStatus($id, Request $request)
    {
        $this->categoryService->changeStatus($id, $request);
    }
}
