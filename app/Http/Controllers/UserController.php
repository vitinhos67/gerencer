<?php

namespace App\Http\Controllers;

use App\Models\Suppliers;
use App\Models\User;
use App\Models\UserSupplier;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8',
            'supplier_id' => 'nullable|exists:suppliers,id',
            'role' => 'required|string|in:admin,moderador,user',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $user = new User($validatedData);
        $user->save();

        $user->assignRole('moderator');
        
        UserSupplier::create([
            'user_id' => $user->id,
            'supplier_id' => $validatedData['supplier_id'],
        ]);

        $success['token'] = $user->createToken('user')->plainTextToken;
        return response()->json($success, 201);
    }
}
