<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Resources\UserResource;

use Illuminate\Support\Facades\Hash;

use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        // $users = User::paginate(10);   //Retrieves 10 users from the database per page

        // Fetch users with count of related orders, paginate 10 per page
        $users = User::withCount('orders')->paginate(10);

        return UserResource::collection($users);   //Ensures that the data returned is in suitable format [like JSON] for API response. 

         // Fetch users from DB, with orders count (to match your usage)
        // $users = User::withCount('orders')->get();
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //validates the request data based on the provided rules
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'address' => 'nullable|string',
            'phone_no' => 'nullable|string',
            'role' => 'required|string|in:admin,customer',
        ]);

        $user = User::create([
            // Used Hash::make() rather than bycrypt - COnsidering robustness and scalability.
            // [Official Laravel Documentation favours using 'Hash' facade for password hashing becuase it offers a more consistent and extensible approach.]
            'password' => Hash::make($validated['password']),
            ...$validated  // Array unpacking operator - This expands the $validated array into individual key-value pairs. 
        ]);

        return new UserResource($user);    ///After creating the user, this method returns the user data as a UserResource.[As a JSON response] 

    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
        $user = User::findOrFail($id);  //Retrieves a user by the provided ID. If no user is found, it will automatically throw a 404 error.
        return new UserResource($user); 
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        // Validates the incoming requuest 
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,  //Ensures that the email remains unique for the specific user
            'phone_no' => 'nullable|string',
            'address' => 'nullable|string',
            'role' => 'required|string|in:admin,customer',
        ]);

        $user = User::findOrFail($id);
        $user->update($validated);
        return new UserResource($user);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {

        $user = User::findOrFail($id);

        // Prevent deleting admins
        if ($user->role === 'admin') {
            // return back()->with('error', 'You cannot delete an admin user');
            return response()->json(['message' => 'Cannot delete admin'], 403);
        }

        // Prrevent deleting customers with existing orders
        if ($user->orders()->exists()) {
            // return back()->with('error', 'Cannot delete customer who has made orders.');
            return response()->json(['message' => 'Customer has orders, cannot delete'], 403);
        }  
        
        $user->delete();

        return response()->json(['message' => 'User deleted Successfully'], 200);  // Returns a JSON response with a success message and a 200 status code.
    }
}
