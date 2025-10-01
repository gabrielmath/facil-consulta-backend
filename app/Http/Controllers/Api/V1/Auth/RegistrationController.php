<?php

namespace App\Http\Controllers\Api\V1\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\RegistrationRequest;
use App\Models\User;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class RegistrationController extends Controller
{
    public function __invoke(RegistrationRequest $request): JsonResponse
    {
        $user = User::create([
            'name'     => $request->validated('name'),
            'email'    => $request->validated('email'),
            'password' => $request->validated('password'),
        ]);

        $user->patient()->create();

        return response()->json([
            'status'  => true,
            'message' => 'User logged in successfully',
            'token'   => $user->createToken('API REST TOKEN')->plainTextToken,
            'user'    => $user
        ], Response::HTTP_OK);
    }
}
