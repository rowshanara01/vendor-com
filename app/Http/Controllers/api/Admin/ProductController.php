<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{

    public function productBySlug(Product $slug)
    {
        return ProductResource::make($slug);
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {

        try {
            $limit = 10;
            if ($request->conditions == null) {
                $products = Product::paginate($limit);
            } elseif ($request->conditions === 'sale') {
                $products = Product::sold()->paginate($limit);
            } else {
                $products = Product::conditions($request->conditions)->paginate($limit);
            }

            return  ProductResource::collection($products);
        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, 500);
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        //
    }
}
