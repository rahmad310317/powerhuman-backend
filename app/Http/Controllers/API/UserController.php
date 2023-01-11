<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use Exception;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Laravel\Fortify\Rules\Password;


class UserController extends Controller
{
    // Login controller
    public function login(Request $request)
    {
        try {
            // validasi request
            $request->validate([
                'email' => 'email|required',
                'password' => 'required',
            ]);
            // find my user by email
            $credentials = request(['email', 'password']);
            if (!Auth::attempt($credentials)) {
                return ResponseFormatter::error('Unauthorized', 500);
            }
            $user = User::where('email', $request->email)->first();
            if (!Hash::check($request->password, $user->password, [])) {
                throw new Exception('Invalid Credentials');
            }
            // generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;
            // return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (Exception $error) {
            return ResponseFormatter::error(['Authentication Failed', $error]);
        }
    }
    // Register controller
    public function register(Request $request)
    {
        try {
            // validasi request
            $request->validate([
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', new Password],
            ]);
            // create user
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            if (!$user) {
                return ResponseFormatter::error('Failed to register', 500);
            }
            // generate token
            $tokenResult = $user->createToken('authToken')->plainTextToken;

            if (!$tokenResult) {
                return ResponseFormatter::error('Failed to token', 500);
            }
            // return response
            return ResponseFormatter::success([
                'access_token' => $tokenResult,
                'token_type' => 'Bearer',
                'user' => $user,
            ]);
        } catch (Exception $error) {
            return ResponseFormatter::error(['Authentication Failed', $error]);
        }
    }
}
