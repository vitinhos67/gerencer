<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        //
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|string|max:255',
            'password' => 'required|string|max:255|min:8',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $validatedData = $validator->validated();
        $user = new User($validatedData);
        $user->save();

        return response()->json($user, 201);
    }

    public function show(Order $order)
    {
        //
    }


    public function edit(Order $order)
    {
        //
    }


    public function destroy(Order $order)
    {
        //
    }
}
