<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate(
            [
                'email' => 'required|email',
                'password' => 'required|min:3|max:30'
            ]
        );
        Auth::attempt($request->only('email', 'password'));
        if(Auth::check()){
            $user = Auth::user();
            $token = $user->createToken('Token')->plainTextToken;
            $response = [
                'success' => true,
                'data' => $user,
                'token' => $token,
            ];
            return response()->json($response, 200);
        }
        return response()->json(['Error' => 'Unauthorized'], 401);
    }
    public function register(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:3|max:30',
        ]);

        $user = User::create([
            'name' => $request->name,
            'email'=>  $request->email,
            'password' => Hash::make($request->password),
        ]);
        $token = $user->createToken('Token')->plainTextToken;

        $response = [
            'success' => true,
            'data' => $user,
            'token' => $token,
        ];
        return response()->json($response, 200);
    }
    
}
