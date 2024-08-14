<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Auth\Authenticatable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Laravel\Sanctum\Contracts\HasApiTokens;

class UserController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',    
                'message' => 'User Not Found',
                'data' => null
            ], 404);
        }

        if (Auth::attempt($credentials)) {
            $token = $user->createToken('authToken')->plainTextToken;

            return response()->json([
                'status' => 'success',
                'message' => 'User Logged In',
                'data' => [
                    'user' => Auth::user(),
                    'token' => $token
                ]
            ], 200);
        }
    }

    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $checkUser = User::where('email', $request->email)->first();

        if ($checkUser) {
            return response()->json([
                'status' => 'error',    
                'message' => 'User Already Exists',
                'data' => null
            ], 404);
        }


        $user = new User();
        $user->id = (string) \Str::uuid();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = bcrypt($request->password);
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => 'User Created',
            'data' => $user 
        ], 201);
    }

    public function logout(Request $request)
    {
        $user = Auth::user();
        $user->tokens()->delete();
        return response()->json([
            'status' => 'success',
            'message' => 'User Logged Out',
            'data' => null
        ], 200);
    }
}
