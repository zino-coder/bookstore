<?php

namespace App\Http\Controllers;

use App\Exceptions\CommonException;
use App\Repositories\ProductRepository;
use App\Services\CartService;
use GuzzleHttp\Exception\ConnectException;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function __construct(
        readonly private ProductRepository $productRepository,
        readonly private CartService $cartService
    )
    {
    }

    public function add($id, Request $request)
    {
        $product = $this->productRepository->getById($id);

        if (!$product) {
            throw new CommonException();
        }

        if ($request->amount && $request->amount > $product->stock) {
            throw new CommonException('Số lượng sản phẩm không đủ');
        }

        $this->cartService->add($id, $product->name, $product->cart_price, $request->amount ?? 1, $product->thumbnail->url ?? '');

        if ($request->ajax()) {
            return view('frontend.layout.components.cart-header');
        }

        return redirect()->route('index');
    }

    public function index()
    {
        return view('frontend.checkout.cart');
    }
}
