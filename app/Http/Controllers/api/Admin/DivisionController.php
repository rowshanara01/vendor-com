<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\Admin\DivisionResource;
use App\Models\Division;
use Illuminate\Http\Request;

class DivisionController extends Controller
{

    public function divisionBydistrictId(Division $division)
    {
        return DivisionResource::collection($division->district()->get(['name','id','bn_name']));
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $divisions =  Division::latest()->get(['name','id','bn_name']);
        return DivisionResource::collection($divisions);
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
    public function show(Division $division)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Division $division)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Division $division)
    {
        //
    }
}