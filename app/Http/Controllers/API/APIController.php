<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Resources\API\LoginResource;
use Illuminate\Http\Request;

class APIController extends Controller
{

    /**
     * @return int
     */
    protected function defaultPerPagePaginate()
    {
        return 10;
    }

    /**
     * @param $authToken
     * @return \Illuminate\Http\JsonResponse
     */
    protected function loginSuccessResponse($authToken)
    {
        return response()->json([
            'message' => 'Login berhasil.',
            'data' => new LoginResource(auth()->user()),
            'token' => $authToken
        ], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function logoutSuccessResponse()
    {
        return response()->json(['message' => 'Logout berhasil.'], 200);
    }

    /**
     * @return \Illuminate\Http\JsonResponse
     */
    protected function loginFailedResponse($message = null)
    {
        if (empty($message))
            return response()->json(['message' => 'Login gagal.', 'data' => null], 401);

        return response()->json(['message' => $message, 'data' => null], 401);
    }
}
