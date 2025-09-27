<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\User;

use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    //

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (!Auth::attempt($request->only('email', 'password'))) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Invalid login credentials'], 401);
            }

            return back()->withErrors(['email' => 'Invalid credentials.']);
        }

        $user = Auth::user();

        // Generate Sanctum token
        $token = $user->createToken('api_token')->plainTextToken;

        if ($request->expectsJson()) {
            // Mobile app / API client
            return response()->json([
                'message' => 'Login successful',
                'token' => $token,
                'user' => $user,
            ]);
        } else {
            // Web client (e.g. form login)
            $request->session()->put('api_token', $token); // Store token in session
            return redirect()->route('dashboard'); // Or wherever you want
        }
    }


    // public function login(Request $request)
    // {
    //     $request->validate([
    //         'email' => 'required|email',
    //         'password' => 'required',
    //     ]);

    //     if (!Auth::attempt($request->only('email', 'password'))) {
    //         return response()->json(['message' => 'Invalid login credentials'], 401);
    //     }

    //     /** @var \App\Models\UserModel $user **/
    //     $user = Auth::user();

    //     $token = $user->createToken('api_token')->plainTextToken;
    //     // session(['api_token' => $token]);
    //     // $token = $user->createToken('api_token')->plainTextToken;

    //     return response()->json([
    //         'message' => 'Login successful',
    //         'token' => $token,
    //         'user' => $user,
    //     ]);
    // }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out successfully']);
    }

    // For mobile app registration
    public function register(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'phone_no' => 'nullable|string',
            'address' => 'nullable|string',
            'role' => 'required|string|in:admin,customer',
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'phone_no' => $validated['phone_no'] ?? '',
            'address' => $validated['address'] ?? '',
            'role' => $validated['role'],
        ]);

        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'token' => $token,
            'user' => $user,
        ], 201);
    }

}
