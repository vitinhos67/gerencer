<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Products;
use App\Models\Suppliers\Suppliers;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller
{
    public function create(Request $request)
    {   
        try {

            $validator = Validator::make($request->all(), [
                'name'           => 'required|string|max:255',
                'description'    => 'nullable|string',
                'price'          => 'required|numeric|min:0|max:999999.99',
                'stock_quantity' => 'required|integer|min:0',
                'sku'            => 'required|string|max:100|unique:products,sku',
                'image_url'      => 'nullable|string|max:255|url',
                'weight'         => 'nullable|numeric|min:0|max:9999.99',
                'additional'     => 'nullable|array',
                'status'         => 'nullable|string|max:50|in:active,inactive,draft',
                'rating'         => 'nullable|numeric|min:0|max:5',
                'supplier_id'    => 'required|integer'
            ]);
        
            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors(),
                ], 422);
            }
     
            $validatedData = $validator->validated();
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