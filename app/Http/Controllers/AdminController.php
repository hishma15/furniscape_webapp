<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    //
    public function dashboard() {
        // Check if the authenticated user is an admin
        if (Auth::check() && Auth::user()->role === 'admin') {
            return view('admin.dashboard');  //Return the admin dashbaord view
        }

        // If not an admin, abort with a 403 Forbidden response
        abort(403, 'Unauthorized access');
    }
}
