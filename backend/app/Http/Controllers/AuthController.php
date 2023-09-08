<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
            // 'latitude' => 'required',
            // 'longitude' => 'required'
        ]);

        // Attempt to authenticate the user
        if (!Auth::attempt($validated)) {
            return response()->json([
                'message' => 'Login information is invalid',
            ], 401);
        }


        // User has been authenticated, get the authenticated user
        $user = User::where('email', $validated['email'])->first();


        $accessToken = $user->createToken('api_token')->plainTextToken;

        $userUpdated = User::where('email', $request->email)->update(['remember_token' => $accessToken]);


        // // Create a location record
        $location = Location::create([
            'latitude' => $request->latitude,
            'longitude' => $request->longitude,
            'type' => 'login',
            'user_id' => $user->id,
        ]);

        return response()->json([
            'name' => $user->name,
             'email' => $user->email,
            'access_token' => $accessToken,
            'token_type' => 'Bearer'
        ]);
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'latitude' => 'required',
            'longitude' => 'required',
        ]);



        // Create a user with a reference to the location record
        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => bcrypt($validated['password']),

        ]);

        // Create a location record
        $location = Location::create([
            'latitude' => $validated['latitude'],
            'longitude' => $validated['longitude'],
            'type' => 'register', // Set the type to 'register'
            'user_id'=> $user->id
        ]);

        return response()->json([
            "message" => "Register successfully"
        ], 201);
    }
}
