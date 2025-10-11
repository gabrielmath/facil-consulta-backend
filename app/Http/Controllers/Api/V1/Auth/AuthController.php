<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\AuthRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response as HTTPResponse;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(AuthRequest $request): JsonResponse
    {
        if (!Auth::attempt($request->only(['email', 'password']))) {
            return response()->json([
                'status'    => false,
                'message'   => 'Email ou senha incorretos, verifique e tente novamente.',
                'typeError' => 'NoMatch',
            ], Response::HTTP_FORBIDDEN);
        }

        $user = User::whereEmail($request->validated('email'))->first();

        return response()->json([
            'status'  => true,
            'message' => 'User logged in successfully',
            'token'   => $user->createToken('API REST TOKEN')->plainTextToken,
            'user'    => $user
        ], Response::HTTP_OK);
    }

    public function logout(): HTTPResponse
    {
        if (Auth::check()) {
            Auth::user()->tokens()->delete();
        }

        return response()->noContent();
    }
}
