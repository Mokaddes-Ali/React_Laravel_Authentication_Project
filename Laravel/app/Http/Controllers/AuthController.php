<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Dotenv\Exception\ValidationException;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $user = User::create($request->validate([
            'first_name' => 'required|string',
            'last_name' => 'string',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]));

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user,
        ]);
    }

    public function login(Request $request)
    {
        $fields = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
            'remember' => 'boolean',
        ]);

        $credentials = (
            'email' => $fields['email'],
            'password' => $fields['password'],
        );

        if (!Auth::attempt($credentials, $fields['remember'])) {
            throw ValidationException::withMessages([
                'email' => 'Invalid credentials',
            ]);


            return response()->json([
                'message' => 'Invalid credentials',
            ], 401);
        }





        return response()->json([
            'message' => 'User logged in successfully',
        ]);
    }
}
