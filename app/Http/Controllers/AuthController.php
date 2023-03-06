<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Enum\UserType;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(Request $request){
        $fieldes = $request->validate([
            'name' => 'required|string',
            'nickname' => 'required|string',
            'email' => 'required|string|unique:users,email',
            'phone' => 'required|integer',
            'password' => 'required|string|confirmed',
            'type' => 'required|integer',
        ]);

        $user = User::create([
            'name' => $fieldes['name'],
            'nickname' => $fieldes['nickname'],
            'email' => $fieldes['email'],
            'phone' => $fieldes['phone'],
            'type' => $fieldes['type'],
            'password' => bcrypt($fieldes['password'])
        ]);

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];
    
        return response($response, 201);
    }

    public function logout(Request $request) {
        auth()->user()->tokens()->delete();

        return [
            'message' => 'Logged out'
        ];
    }

    public function login(Request $request){
        $fields = $request->validate([
            'email' => 'required|string|',
            'password' => 'required|string|'
        ]);

        // Check email
        $user = User::where('email', $fields['email'])->first();

        // Check password
        if(!$user || !Hash::check($fields['password'], $user->password)){
            return response([
                'message' => 'Bad creds'
            ], 401);
        }

        $token = $user->createToken('myapptoken')->plainTextToken;

        $response = [
            'user' => $user,
            'token' => $token
        ];

        return response($response, 201);
    }
    
}
