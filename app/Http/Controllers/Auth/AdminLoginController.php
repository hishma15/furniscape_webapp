<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    //
    public function create()
    {
        return view('auth.admin-login'); // Blade view for admin login
    }

    public function store(Request $request) 
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ]);

        if (Auth::attempt($request->only('email','password'), $request->boolean('remember'))) {

            //  $request->session()->regenerate();
            
            // Check if the authenticated user is an admin
            /** @var \App\Models\UserModel $user  **/
            $user = Auth::user();
            if ($user->role === 'admin') {
                
                if ($request->expectsJson()) {
                    // API request, return token as JSON
                    $token = $user->createToken('admin-api-token')->plainTextToken;

                    return response()->json([
                        'token' => $token,
                        'user' => $user,
                    ]);
                } else {
                    // Web request — create token & store in session
                    $token = $user->createToken('admin-api-token')->plainTextToken;
                    $request->session()->put('api_token', $token);

                    return redirect()->route('admin.dashboard');
                }


                return redirect()->route('admin.dashboard');
            }

            Auth::logout();
            return back()->withErrors(['email' => 'Unauthorized login attempt.']);
        }

        return back()->withErrors(['email' => 'Invalid credentials.']);
    }

    public function destroy(Request $request) {
        Auth::logout();

        $request->session()->forget('api_token'); 
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/admin/login');
    }

}
