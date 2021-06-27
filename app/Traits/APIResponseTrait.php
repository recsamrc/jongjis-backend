<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait APIResponseTrait
{
    public function successResponse($message = '', $data = [])
    {
        return response()->json([
            'message' => $message,
            'data' => $data,
        ], Response::HTTP_OK);
    }

    public function errorResponse($message, $errorResult, $code = Response::HTTP_NOT_FOUND)
    {

    }
}
