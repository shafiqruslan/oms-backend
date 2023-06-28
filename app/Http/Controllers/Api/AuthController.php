<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $credentials['email'])->first();
        $token = $user->createToken($credentials['email'])->plainTextToken;

        if (Auth::attempt($credentials)) {
            $response = [
                'data' => $user,
                'message' => 'Successfully Logged in',
                'token' => $token
            ];
            return response()->json($response, 200);
        } else {
            $response = [
                'message' => 'Failed Logged in',
            ];
            return response()->json($response, 401);
        }
    }
}
