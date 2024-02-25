<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;
use Tymon\JWTAuth\Facades\JWTAuth;

class AuthController extends Controller
{

    public function register( RegisterRequest $request )
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'is_admin' => false
        ]);

        $token = JWTAuth::fromUser($user);

        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ], Response::HTTP_CREATED)->withCookie($cookie);
    }

    public function login( LoginRequest $request )
    {
        if (!Auth::attempt($request->only('email', 'password'))) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid credentials'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user();
        $token = JWTAuth::fromUser($user);

        $cookie = cookie('jwt', $token, 60 * 24);

        return response()->json([
            'success' => true,
            'data' => [
                'token' => $token
            ]
        ])->withCookie($cookie);
    }

}
