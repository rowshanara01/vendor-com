<?php

namespace App\Http\Controllers\api\Seller;

use App\Http\Controllers\Controller;
use App\Http\Resources\Seller\SellerResource;
use App\Models\Seller;
use Illuminate\Http\Request;

class sellerListController extends Controller
{
    public function index(Request $request)
    {
        $seller = Seller::VerifiedSeller()->withCount('products')->latest()->paginate($request->show);
        // dd($seller);
        return SellerResource::collection($seller);
    }

    public function sellerProducts(Seller $slug, Request $request)
    {
        try {

            $sort = $request->input('sort');
            if($sort === 'default'){
                $products =  $slug->products()->paginate($request->show);
            }else{
                $products =  $slug->products()->conditions($sort)->paginate($request->show);
            }

            return (new SellerResource($slug))
                ->additional(['products' => [
                    $products
                ]]);
            // return response()->json($slug);
        } catch (\Exception $e) {
            return send_ms($e->getMessage(), false, $e->getCode());
        }
    }
}
