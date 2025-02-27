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
            'email'    => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (! $user || ! Hash::check($request->password, $user->password)) {
            return response()->json(['success' => false, 'errors' => 'invalid-credentials'], 401);
        }

        $token = $user->createToken('user_login')->plainTextToken;

        $response = ['token' => $token, "user" => $user];

        if ($user->hasRole('admin')) {
            $response['supplier'] = UserSupplier::where('user_id', $user->id)->first()->supplier;
        }

        return response()->json($response, 200);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'You have been successfully logged out.'], 200);
    }
}