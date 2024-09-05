<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Tymon\JWTAuth\Facades\JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;
use App\Models\userModel;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function registerApprover(Request $request)
    {
        // Validate data to make sure it's correctly inputted
        $request->validate([
            'username'=> 'required|string|max:16',
            'name' => 'required|string|max:16',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|max:16',
        ]);

        // Create a new user in the database
        $user = userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'approver',
        ]);

        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function registerAdmin(Request $request)
    {
        // Validate data to make sure it's correctly inputted
        $request->validate([
            'username'=> 'required|string|max:16',
            'name' => 'required|string|max:16',
            'email' => 'required|string|email|unique:users',
            'password' => 'required|string|min:6|max:16',
        ]);

        // Create a new user in the database
        $user = userModel::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'password' => Hash::make($request->password),
            'role' => 'admin',
        ]);

        //returns a message upon successful registration
        return response()->json([
            'message' => 'User created successfully',
            'user' => $user
        ]);
    }

    public function login(Request $request)
    {
        // get the username and password from the request
        $credentials = $request->only('username', 'password');

        try {
            // attempt to authenticate the user using the default guard
            if (!$token = Auth::guard('userModel')->attempt($credentials)) {
                // Shows error message upon unsuccessful login
                return response()->json(['error' => 'Unauthorized'], 401);
            }
        } catch (JWTException $e) {
            // shows error message upon unexpected issue
            return response()->json(['error' => 'Could not create token'], 500);
        }

        // shows token upon successful login
        return response()->json(compact('token'));
    }

    public function logout()
    {
        try {
            // Get the current authenticated user token to invalidate to prevent further uses after logout.
            JWTAuth::invalidate(JWTAuth::getToken());
            return response()->json([
                'message' => 'Successfully logged out',
            ]);
        } catch (JWTException $e) {
            // Catch any errors during token invalidation process
            return response()->json(['error' => 'Failed to logout, please try again'], 500);
        }

    }

    //Function to get current user
    public function getUser(){
        return response()->json(['user' => Auth::guard('userModel')->user()]);
    }

    //Function to get all users
    public function getAllUser(){
        $user = userModel::get();
        return response()->json(['user' => $user]);
    }
}
