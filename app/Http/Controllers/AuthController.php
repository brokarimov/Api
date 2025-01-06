<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Jobs\SendEmailJob;
use App\Models\Code;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Password;

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
        if (Auth::check()) {
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
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);


        $verificationCode = rand(1000, 9999);

        Code::create([
            'code' => $verificationCode,
            'user_id' => $user->id,
        ]);

        SendEmailJob::dispatch($user->email, ['code' => $verificationCode]);
        return response()->json([
            'success' => true,
            'message' => 'Registration successful. A verification code has been sent to your email.',

        ], 201);
    }

    public function verify(Request $request)
    {

        $request->validate([
            'code' => 'required|numeric',
        ]);

        $code = Code::where('code', $request->code)->first();

        $user = User::where('id', $code->user_id)->first();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User not found.',
            ], 404);
        }


        $code = Code::where('user_id', $user->id)
            ->where('code', $request->code)
            ->first();

        if (!$code) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid verification code.',
            ], 400);
        }


        $user->email_verified_at = now();
        $user->save();


        $code->delete();


        $token = $user->createToken('Token')->plainTextToken;


        return response()->json([
            'success' => true,
            'message' => 'Verification successful.',
            'token' => $token,
            'user' => $user,
        ], 200);
    }

    public function profile(Request $request)
    {
        $request->validate([
            'name' => 'required|max:255',
        ]);
        $user = auth()->user();

        $user->name = $request->name;
        return response()->json([
            'success' => true,
            'message' => 'Info is updated',
            'user' => $user,
        ], 200);
    }

    public function password(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        $newPassword = rand(10000, 99999);

        $user->password = Hash::make($newPassword);
        $user->save();

        SendEmailJob::dispatch($user->email, ['code' => $newPassword]);

        return response()->json([
            'success' => true,
            'message' => 'A new password has been sent to your email.',
        ], 200);
    }
}
