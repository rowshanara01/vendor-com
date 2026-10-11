<?php

namespace App\Http\Controllers\Api\User;

use App\Models\Wishlist;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\User\WishlistResource;
use Illuminate\Support\Facades\Auth;

class WishlistController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $wishlist = Auth::guard('user-api')->user()->userWishlistProducts()->get();
        return WishlistResource::collection($wishlist);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $user = Auth::guard('user-api')->user();

        $count = $user->userWishlistProducts()->where('product_id', $request->product_id)->count();

        if($count == 0){
            $user->userWishlistProducts()->attach($request->product_id);
            return send_ms('Attach Successfully', true , 201);
        }else{
            $user->userWishlistProducts()->detach($request->product_id);
            return send_ms('Detach Successfully', true , 200);

        }
        // dd($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Wishlist $wishlist)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Wishlist $wishlist)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Wishlist $wishlist)
    {
        //
    }
}
