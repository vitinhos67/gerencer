<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProductRequest;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Suppliers\Suppliers;
class ProductsController extends Controller
{
    public function create(StoreProductRequest $request)
    {   
        try {
            $validatedData = $request->validated();
            $validatedData['additional'] = json_encode($validatedData['additional']);
            if(!Suppliers::find($validatedData['supplier_id'])) {
                return response()->json([
                    'errors' => ['invalid-supplier'],
                ], 422);
            }

            $product = Products::create($validatedData);
            return response()->json($product, 201);
        } catch(\Exception $e) {
            return response()->json($e->getMessage(), 500);
        }
    }

    public function get(Request $request)
    {
        return response()->json(Products::get(), 200);
    }
}