<?php

namespace App\Http\Controllers;

use App\Services\HomeService;
use App\Services\ProductService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function __construct(
        private readonly HomeService $homeService,
        private readonly ProductService $productService,
    )
    {
    }

    public function index()
    {
        $hotProduct = $this->productService->getHotPoructForHome();
        $featureProduct = $this->productService->getFeaturedProduct();

        return view('frontend.home.index', ['hotProduct' => $hotProduct, 'featureProduct' => $featureProduct]);
    }
}
