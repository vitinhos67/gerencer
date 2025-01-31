<?php

namespace App\Http\Controllers;

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

        $this->verifyPermissions($request->input('role'), $request->user());

        $validatedData = $validator->validated();
        $user = new User($validatedData);
        $user->save();

        $user->assignRole($request->input('role'));

        if (isset($validatedData['supplier_id'])) {
            UserSupplier::create([
                'user_id' => $user->id,
                'supplier_id' => $validatedData['supplier_id'],
            ]);
        }

        $success['token'] = $user->createToken('user')->plainTextToken;
        return response()->json($success, 201);
    }

    private function verifyPermissions(string $role, User|null $user)
    {
        if ($role !== 'user' && !$user) {
            abort(response()->json([
                'message' => 'Não é possível criar o usuário.',
            ], 401));
        }
    
        if ($role === 'user' && !$user) {
            return;
        }
    
        if ($role === 'admin' && !$user->hasRole('admin')) {
            abort(response()->json([
                'message' => 'Apenas administradores podem criar outros administradores.',
            ], 401));
        }
    
        if ($role === 'moderador' && !$user->hasAnyRole(['admin', 'moderador'])) {
            abort(response()->json([
                'message' => 'Apenas administradores ou moderadores podem criar moderadores.',
            ], 401));
        }
    
        if ($role === 'user' && !$user->hasAnyRole(['admin', 'moderador'])) {
            abort(response()->json([
                'message' => 'Apenas administradores ou moderadores podem criar usuários.',
            ], 401));
        }
    }
}
