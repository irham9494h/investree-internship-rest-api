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
            'token_type' => 'Bearer',
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

    /**
     * @param $data
     * @param $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function createdResponse($data, $message = null)
    {
        if (empty($message))
            return response()->json(['message' => 'Berhasil.', 'data' => $data], 201);
        return response()->json(['message' => $message, 'data' => $data], 201);
    }

    /**
     * @param null $data
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function successResponse($data = null, $message = null)
    {
        if (empty($message))
            return response()->json(['message' => 'Berhasil!.', 'data' => $data], 200);

        return response()->json(['message' => $message, 'data' => $data], 200);
    }

    /**
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function errorResponse($message = null)
    {
        if (empty($message))
            return response()->json(['message' => 'Terjadi kesalahan pada server!.'], 500);

        return response()->json(['message' => $message], 500);
    }

    /**
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function nullResponse($message = null)
    {
        if (empty($message))
            return response()->json(['message' => 'Data kosong.'], 204);

        return response()->json(['message' => $message], 204);
    }

    /**
     * @param null $message
     * @return \Illuminate\Http\JsonResponse
     */
    protected function notFoundResponse($message = null)
    {
        if (empty($message))
            return response()->json(['message' => 'Data tidak ditemukan.'], 404);

        return response()->json(['message' => $message], 404);
    }

    /**
     * @param $model
     * @param $request
     * @return mixed
     */
    protected function paginateRespose($model, $request)
    {
        if ($request->paginate === 'true') {
            if ($request->per_page) {
                return $model->paginate($request->per_page)->appends($request->except('page'));
            } else {
                return $model->paginate($this->defaultPerPagePaginate())->appends($request->except('page'));
            }
        } else {
            return $model->get();
        }
    }
}
