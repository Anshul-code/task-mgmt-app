<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    /**
     * Register User
     *
     * @param \App\Http\Requests\RegisterRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function register(RegisterRequest $request): JsonResponse
    {
        $data = $request->validated();

        $user = User::create($data);

        $token = $user->createToken('authtoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $user,
            'message' => __('User registered.')
        ]);
    }

    /**
     * Login User
     *
     * @param \App\Http\Requests\LoginRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function login(LoginRequest $request): JsonResponse
    {
        $user = User::where('email', $request->email)->first();

        if ($user == null || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => __('Record with these credentials not found.')
            ]);
        }

        $token = $user->createToken('authtoken')->plainTextToken;

        return response()->json([
            'success' => true,
            'token'   => $token,
            'user'    => $user,
            'message' => __('Log in successfull')
        ]);
    }


}
