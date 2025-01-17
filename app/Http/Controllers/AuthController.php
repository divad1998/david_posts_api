<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller{

    function register(Request $request) {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'email' => 'required|string|email|max:255|unique:users,email',
                'password' => [
                    'required', 'string', 'min:8', 'regex:/[a-z]/', 'regex:/[A-Z]/', 
                    'regex:/[0-9]/', 'regex:/[@$!%*#?&]/', 'confirmed', 
                ],
            ],
            [
                'password.regex' => 'The password must include at least one lowercase letter, one uppercase letter, one digit, and one special character.',
            ]
        );
    
        $user =new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->email_verified_at = now();
        $user->save();
    
        return response()->json([
            'status' => true, 'message' => "User created successfully."
        ], 201);
    }

    function login(Request $request) {
        $request->validate([
                'email' => 'required|string|email',
                'password' => 'required|string|min:8',
        ]);

        //authenticate the user
        if (! $token = auth()->attempt(['email' => $request->email, 'password' => $request->password])) {
            return response()->json([
                'status' => false, 'message' => "Invalid credentials."
            ], 401); 
        }

        return response()->json([
            'status' => true, 'message' => 'Login successful.', 
            'data' => [
                                'token' => $token,
                                'token_type' => 'bearer',
                                'expires_in' => auth()->factory()->getTTL() * 60, // Token valid for 3600 seconds (1 hour)
                                'time_unit' => 'seconds'
                            ]
            ], 200);
    }
}
