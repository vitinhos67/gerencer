<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SuppliersController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'contact_name' => 'nullable|string|max:255',
            'email' => 'required|email|unique:suppliers,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:255',
            'city' => 'nullable|string|max:255',
            'state' => 'nullable|string|max:255',
            'postal_code' => 'nullable|string|max:20',
            'country' => 'nullable|string|max:255',
            'user' => 'required|array',
            'user.email' => 'required|string|email|max:255',
            'user.name' => 'required|string|max:255',
            'user.password' => 'required|string|max:255',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $supplier = Suppliers::create($validatedData);

        $supplier->token  = $this->createAdmin($validatedData['user']);
        return response()->json($supplier, 201);
    }

    public function createAdmin($data)
    {
        $user = new User($data);
        $user->save();
        $user->assignRole('admin');
        return $user->createToken('user')->plainTextToken;
    }
}
