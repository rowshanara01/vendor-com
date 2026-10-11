<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use Illuminate\Http\Request;

class shopController extends Controller
{
    public function index(Request $request)
    {
        try {

            $condition = $request->condition;
            $per_page_data = $request->show;
            $brandSlug = $request->brand;
            $categorySlug = $request->category;
            $price_range = $request->price_range;
            $search = $request->search;
            $sort = $request->sort;

            $products = Product::latest()->published()
                ->when($condition != 'all', function ($q) use ($condition) {
                    return $q->conditions($condition);
                })
                ->when($brandSlug, function ($q) use ($brandSlug) {
                    $brandIds = Brand::select('id')->whereIn('slug', $brandSlug)->pluck('id')->toArray();
                    return $q->whereIn('brand_id', $brandIds);
                })
                ->when($categorySlug, function ($q) use ($categorySlug) {
                    $categoryIds = Category::select('id')->whereIn('slug', $categorySlug)->pluck('id')->toArray();

                    if (count($categoryIds) > 0) {
                        return $q->whereIn('category_id', $categoryIds);
                    } else {
                        $sub_categoryIds = SubCategory::select('id')->whereIn('slug', $categorySlug)->pluck('id')->toArray();
                        return $q->whereIn('sub_category_id', $sub_categoryIds);
                    }

                })
                ->when($search, function ($q) use ($search) {
                    return $q->where('name', 'LIKE', '%' . $search . '%');
                })

                ->when($sort != 'default', function ($q) use ($sort) {
                    if ($sort === "priceLowToHigh") {
                        return $q->orderBy("price", "ASC");
                    } elseif ($sort === "priceHighToLow") {
                        return $q->orderBy("price", "DESC");
                    } elseif ($sort === "nameAToZ") {
                        return $q->orderBy("name", "DESC");
                    } else {
                        return $q->orderBy("name", "ASC");
                    }
                })
                ->when($price_range, function ($q) use ($price_range) {

                    $min_price = $price_range[0];
                    $max_price = $price_range[1];

                    return $q->whereBetween('price', [$min_price, $max_price]);
                })
                ->paginate($per_page_data);

            return ProductResource::collection($products);

        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }

    public function sideBar()
    {
        try {

            $categories = product_count_upto_zero(Category::withCount('products')->status('active')->get());
            $brands = product_count_upto_zero(Brand::withCount('products')->status('active')->get());

            $min_price = Product::min('price');
            $max_price = Product::max('price');

            return ProductResource::collection([
                'categories' => $categories,
                'brands' => $brands,
                'price' => [
                    'min_price' => $min_price,
                    'max_price' => $max_price,
                ],
            ]);

        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }
}
