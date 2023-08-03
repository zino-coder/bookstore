<?php

namespace App\Services;

use App\Exceptions\CommonException;
use App\Models\Product;
use App\Repositories\MediaRepository;
use App\Repositories\ProductRepository;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductService
{
    private $productRepository;
    public function __construct(
        ProductRepository $productRepository,
        readonly MediaRepository $mediaRepository
    )
    {
        $this->productRepository = $productRepository;
    }

    public function getAllProduct()
    {
        return $this->productRepository->getProducts();
    }

    /**
     * @throws CommonException
     */
    public function store($request)
    {
        try {
            DB::beginTransaction();
            $product = $this->productRepository->create([
                'name' => $request->name,
                'slug' => Str::slug($request->name),
                'description' => $request->description,
                'category_id' => $request->category_id,
                'is_active' => $request->is_active ? 1 : 0,
            ]);

            if ($request->hasFile('thumbnail')) {
                $thumbImage = $request->file('thumbnail');
                $imageName = Carbon::now() . '-' .$thumbImage->getClientOriginalName();
                $url =  $thumbImage->storeAs('thumbnails', $imageName, 'public');

                $this->mediaRepository->create([
                    'title' => $imageName,
                    'url' => $url,
                    'type' => 'thumbnail',
                    'mediable_type' => Product::class,
                    'mediable_id' => $product->id,
                ]);
            }

            if (isset($request->catalog)) {
                foreach ($request->catalog as $item) {
                    $imageName = Carbon::now() . '-' . $item->getClientOriginalName();
                    $url = $item->storeAs('catalog', $imageName, 'public');

                    $this->mediaRepository->create([
                        'title' => $imageName,
                        'url' => $url,
                        'type' => 'catalog',
                        'mediable_type' => Product::class,
                        'mediable_id' => $product->id,
                    ]);

                }
            }

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
//            throw new CommonException('Something Wrong!');
        }
    }

    public function getProductById($id)
    {
        return $this->productRepository->getById($id);
    }
}
