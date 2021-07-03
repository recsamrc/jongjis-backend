<?php

namespace App\Traits;

use Illuminate\Http\Response;

trait APIResponseTrait
{
    public function successResponse($result)
    {
        $response = [];

        if (is_array($result) && isset($result['data']))
            $response['data'] = $result['data'];
        else
            $response['data'] = $result;

        if (is_array($result) && isset($result['pagination']))
            $response['pagination'] = $result['pagination'];

        return response()->json($response, Response::HTTP_OK);
    }

    public function successStatusResponse($result = null)
    {
        if (is_object($result) && $result->original && isset($result->original['error'])) {
            return $result;
        }

        return response()->json(['data' => [
            'status' => '1'
        ]], Response::HTTP_OK);
    }

    public function errorStatusResponse()
    {
        return response()->json([
            'data' => [
                'status' => '0'
            ]
        ], Response::HTTP_OK);
    }

    public function errorResponse($message, $errorResult = [], $code = Response::HTTP_NOT_FOUND)
    {
        if (request()->expectsJson()) {
            $error = [
                'code' => $code,
                'message' => $message,
            ];

            if (!empty($errorResult) && !is_string($errorResult)) {
                $errorMessages = is_array($errorResult) ? array_values($errorResult) : array_values($errorResult->toArray());
                $errorMessage = $errorMessages[0];
                $message = is_array($errorMessage) ? $errorMessage[0] : $errorMessage;
                $error['message'] = $message;
                $error['detail'] = $errorResult;
            }

            $response['error'] = $error;

            return response()->json($response, $code);
        } else {
            return $errorResult;
        }
    }
}
