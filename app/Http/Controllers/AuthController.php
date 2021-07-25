<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    //
    public function register(Request $request){
        $fields = $request->validate([
            'name' => 'required|string',
            'email' => 'required|string|unique:users',
            'password' => 'required|string|confirmed'
        ]);

        $user = User::create([
            'name' => $fields['name'],
            'email' => $fields['email'],
            'password' => bcrypt($fields['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

    // create a logout func so as to logout and delete our token so it doesnt get saved
    public function logout(Request $request)
    {
        auth()->user()->tokens()->delete();
        
        return ['message' => 'Logged Out'];
    } 

    // create the login func to login
    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string',
            'password' => 'required|string'
        ]);

    //    check email
        $user = User::where('email', $fields['email'])->first();

        // check password
        if (!$user || !Hash::check($fields['password'], $user->password)){
            return response(['message' => 'Wrong details'], 401);
        } 

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 200);
    }

}
