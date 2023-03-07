<?php

namespace App\Http\Controllers\Auth\Api;

use App\Models\User;

use App\Enum\UserType;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterUsers;
use App\Http\Controllers\Controller;

class RegisterController extends Controller
{
    public function user(RegisterUsers $request, User $user)
    {
        $userData = $request->only(
            'name',
            'nickname',
            'email',
            'phone',
            'password'
        );

        $userData['type'] = UserType::USER;

        if(!$user = $user->create($userData)){
            abort(500, 'Error creating a new user');
        }

        $user->assignRole('user');
        
        return response()->json(['data' => ['user' => $user]]);
    }

    public function admin(RegisterUsers $request, User $user)
    {
        $userData = $request->only(
            'name',
            'nickname',
            'email',
            'phone',
            'password'
        );

        $userData['type'] = UserType::ADMIN;

        if(!$user = $user->create($userData)){
            abort(500, 'Error creating a new user');
        }

        $user->assignRole('admin');
        
        return response()->json(['data' => ['user' => $user]]);
    }
}
