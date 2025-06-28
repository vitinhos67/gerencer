<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Suppliers\UserSupplier;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)
            ->when($request->has('include_supplier_if_admin') || true, function ($query) { // Or based on other conditions
                $query->with('userSupplier.supplier');
            })
            ->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'errors' => 'invalid-credentials'], 401);
        }

        $token = $user->createToken('user_login')->plainTextToken;
        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token,
                'user' => $user,
                'supplier' => $user->hasRole(roles: 'admin') ? $user->userSupplier->supplier : null
            ]
        ], 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }
}