<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */
    // Login the User
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        if(!Auth::attempt($credentials)) {
            throw ValidationException::withMessages([
               'email' => 'Your provided credentials could not be verified.'
           ]);
        }

        $token = $user->createToken("API TOKEN");

        return response([
            'success' => true,
            'message' => 'User logged in successfully',
            'user' => $user,
            'token' => $token->plainTextToken
        ]);
    }

    //Log out the user
    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();
        return response()->json();
    }
}
