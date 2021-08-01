<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\APIController;
use App\Models\Client;
use App\Traits\AuthenticatesClientTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends APIController
{
    public function __construct()
    {
        $this->middleware('auth:api', ['except' => ['login', 'register']]);
    }

    public function login()
    {
        $credentials = request(['email', 'password']);

        if (!$token = auth()->guard('api')->attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function register(Request $request)
    {
        $attributes = $request->all();
        $credentials = $request->only('email', 'password');

        $attributes['password'] = Hash::make($attributes['password']);
        Client::create($attributes);

        $token = auth()->guard()->attempt($credentials);
        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }
}
