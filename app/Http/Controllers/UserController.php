<?php

namespace App\Http\Controllers;

use App\Models\Suppliers\UserSupplier;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function createModerator(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:8',
            'supplier_id' => 'nullable|exists:suppliers,id',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $user = new User($validatedData);
        $user->save();

        $user->assignRole('moderador');
        
        UserSupplier::create([
            'user_id' => $user->id,
            'supplier_id' => $validatedData['supplier_id'],
        ]);

        $success['token'] = $user->createToken('user')->plainTextToken;
        return response()->json($success, 201);
    }

    public function createUser(Request $request) 
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $user = new User($validatedData);
        $user->save();

        $user->assignRole('user');

        $success['token'] = $user->createToken('user')->plainTextToken;
        return response()->json($success, 201);
    }
}
