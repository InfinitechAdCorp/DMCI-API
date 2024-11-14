<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    public function getAll()
    {   
        $user = Auth::id();

        if ($user) {
            $records = User::where('user_id', $user)->get();
            $data = ['code' => 200, 'records' => $records];
            return response($data); 
        }
        else{
            return response()->json([
                'status' => 'error',
                'message' => 'User not authenticated.'  
            ], 401);
        }
    }

    // Add User
    public function add(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8',
        ]);

        try {
            $user = new User();
            $user->name = $validated['name'];
            $user->email = $validated['email'];
            // Hash the password before storing
            $user->password = Hash::make($validated['password']);
            $user->save(); // Save the user to the database

            // Return a successful response
            return response()->json([
                'message' => 'User created successfully!',
                'user' => $user,
            ], 201); // 201 is the HTTP status code for "created"
        } catch (\Exception $e) {
            // Return error response if something goes wrong
            return response()->json([
                'error' => 'An error occurred while creating the user.',
                'message' => $e->getMessage()
            ], 500); // 500 is the HTTP status code for "server error"
        }
    }

    public function loginUser(Request $request)
    {
        // Validate input
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|string|min:6',
        ]);

        // Find user by email
        $user = User::where('email', $request->email)->first();

        // Check if user exists and password matches
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'Invalid email or password.',
            ], 401);
        }

        // Revoke previous tokens and create a new token
        $user->tokens()->delete();
        $token = $user->createToken('auth_token')->plainTextToken;

        return response()->json([
            'message' => 'Login successful.',
            'access_token' => $token,
            // 'token_type' => 'Bearer',
            // 'user' => $user,
        ]);
    }

    public function userLogout(Request $request)
    {
        // Check if the user is authenticated
        if (Auth::check()) {

            // Revoke the current access token for Sanctum
            $request->user()->currentAccessToken()->delete();
            // In case of an error
            return response()->json(['success' => true, 'message' => 'Logged out successfully.']);
        }

        // If the user is not authenticated
        return response()->json(['error' => 'Not authenticated'], 401);
    }
}
