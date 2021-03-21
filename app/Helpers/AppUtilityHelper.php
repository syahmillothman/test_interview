<?php

namespace App\Helpers;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

class AppUtilityHelper
{

    const API_ERROR_MESSAGE = 'ERROR';
    const API_OK_MESSAGE = 'OK';

    /**
     * @param array       $data
     * @param $httpCode
     * @param $message
     */
    public function giveSuccessResponse($data = null, $httpCode = 200, $message = null): JsonResponse
    {
        $message = is_null($message) ? self::API_OK_MESSAGE : $message;
        return response()->json(['data' => $data, 'status_code' => $httpCode, 'message' => $message]);
    }

    /**
     * @param array       $data
     * @param $httpCode
     * @param $message
     */
    public function giveErrorResponse($data = null, $httpCode = 400, $message = null): JsonResponse
    {
        $message = is_null($message) ? self::API_ERROR_MESSAGE : $message;
        return response()->json(['data' => $data, 'status_code' => $httpCode, 'message' => $message]);
    }

    /**
     * @param array       $data
     * @param $httpCode
     * @param $message
     */
    public function giveNoContentResponse($data = null, $httpCode = 203, $message = null): Response
    {
        $message = is_null($message) ? self::API_OK_MESSAGE : $message;
        return response()->noContent();
    }
}
