<?php

namespace App\Repositories;

use App\Http\Requests\Products\CreateProductRequest;
use App\Models\Product;
use App\Repositories\Contract\ImageRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProductRepository implements \App\Repositories\Contract\ProductsRepositoryInterface
{

    public function __construct(protected ImageRepositoryInterface $imageRepository)
    {

    }

    public function create(CreateProductRequest $request): Product|false
    {
        try {
            DB::beginTransaction();
            $data = $this->formRequestData($request);
            $data['attributes'] = $this->addSlugToAttributes($data['attributes']);

            $product = Product::create($data['attributes']);

            $this->setProductData($product, $data);

            DB::commit();

            return $product;
        } catch (\Exception $exception) {
            DB::rollBack();
            logs()->warning($exception);
            return false;
        }
    }

    protected function setProductData(Product $product, array $data): void
    {
        if ($product->categories()->exists()){
            $product->categories()->detach();
        }

        if (!empty($data['categories'])){
            $product->categories()->attach($data['categories']);
        }

        $this->imageRepository->attach(
            $product,
            'images',
                $data['attributes']['images'] ?? [],
            $product->slug);
    }

    protected function formRequestData(CreateProductRequest $request): array
    {
        return [
            'attributes' => collect($request->validated())->except(['categories'])->toArray(),
            'categories' => $request->get('categories', [])
        ];
    }

    protected function addSlugToAttributes(array $attributes): array
    {
        return array_merge(
            ['slug' => Str::of($attributes['title'])->slug()->value()],
            $attributes
        );
    }
}
