<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $data = $request->validate([
           'email' => 'required|string|email|max:255|unique:users',
           'name' => 'required|string|max:255',
           'password' => 'required|string|min:8',
        ]);
        $user = User::create($data);
        $token = $user->createToken('auth_token')->plainTextToken;
        return response()->json(['token' => $token, 'message' => 'Успешно зарегистрирован!'], 200);
    }
}
