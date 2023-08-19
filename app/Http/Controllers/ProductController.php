<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Services\CategoryService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    private $productService;

    public function __construct(
        ProductService $productService,
        readonly private CategoryService $categoryService
    )
    {
        $this->productService = $productService;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $categories = Category::where('parent_id', 0)->with(['children'])->get();
        $products = $this->productService->getAllProduct($request);

        return view('admin.product.index',  compact(['products', 'categories']));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $parentCategories = $this->categoryService->getParentCategories();

        return view('admin.product.form', compact('parentCategories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        dd($request->all());
        $this->productService->store($request);

        return redirect()->route('products.index')->with('success', 'Create successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $name = 'catalog';
        $product = Product::with([
            'media' => function ($sql) use ($name) {
                return $sql->where('type', $name);
            }
        ])
            ->get();
        dd($product);
        return view('admin.product.show');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
