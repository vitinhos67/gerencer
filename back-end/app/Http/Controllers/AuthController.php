<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Suppliers\UserSupplier;
use App\Models\User\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

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

        $useCookies = $request->header('X-Use-Cookies') === 'true' || $request->has('use_cookies');
        
        if ($useCookies) {
            Auth::login($user);
            
            return response()->json([
                'success' => true,
                'data' => [
                    'user' => $user,
                    'supplier' => $user->hasRole(roles: 'admin') ? $user->userSupplier->supplier : null,
                ]
            ], 200)->withCookie(
                'laravel_session',
                $request->session()->getId(),
                60 * 24 * 7, // 7 dias
                '/',
                null,
                true, // secure
                true, // httpOnly
                false,
                'Lax' // sameSite
            );
        } else {
            // Login com token (compatibilidade)
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
    }

    public function logout(Request $request)
    {
        if ($request->hasCookie('laravel_session')) {
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();
            
            return response()->json(['message' => 'You have been successfully logged out.'], 200)
                ->withCookie('laravel_session', '', -1); // Remove o cookie
        } else {
        $request->user()->tokens()->delete();
        $request->user()->currentAccessToken()->delete();
        return response()->json(['message' => 'You have been successfully logged out.'], 200);
        }
    }

    public function me(Request $request)
    {
        $user = $request->user();
        
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        $user->load('userSupplier.supplier');
        
        return response()->json([
            'success' => true,
            'data' => [
                'user' => $user,
                'supplier' => $user->hasRole(roles: 'admin') ? $user->userSupplier->supplier : null
            ]
        ]);
    }
}