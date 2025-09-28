<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    public function test(): JsonResponse
    {
        return response()->json(['message' => 'Endpoint funcionando!'], Response::HTTP_OK);
    }
}
