<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use  Illuminate\Http\Response;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Facades\Validator;
use Symfony\Component\HttpFoundation\Response as ResponseAlias;
use App\Models\Passenger;
use App\Models\User;

class AuthController extends Controller
{
    /**
     * Handle an authentication attempt.
     */

    // Login the Passenger
    // public function store(Request $request)
    // {

    //     $data = $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required|string|min:8',
    //     ]);

    //     $passenger = Passenger::where('email', $data['email'])->first();

    //     // if(!$passenger || !Auth::attempt($data)) {
    //     //     throw ValidationException::withMessages([
    //     //        'email' => 'Your provided credentials could not be verified.'
    //     //    ]);
    //     // }

    //     $token = $passenger->createToken("API TOKEN");

    //     return response([
    //         'success' => true,
    //         'message' => 'Passenger logged in successfully',
    //         'data' => $passenger,
    //         'token' => $token->plainTextToken
    //     ]);
    // }

    /**
     * Log the passenger out of the application.
     */
    // public function destroy(Request $request)
    // {
    //     $request->passenger()->tokens()->delete();

    //     return response()->json();
    // }

    // Login the User
    public function login(Request $request)
    {

        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:8',
        ]);

        $user = User::where('email', $credentials['email'])->first();

        // if(!$passenger || !Auth::attempt($credentials)) {
        //     throw ValidationException::withMessages([
        //        'email' => 'Your provided credentials could not be verified.'
        //    ]);
        // }

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
