<?php

namespace App\Helpers;

class ApiResponse
{
    public static function success($message, $data = null, $statusCode = 200)
    {
        return response()->json([
            'statusCode' => $statusCode,
            'success'    => true,
            'message'    => $message,
            'data'       => $data,
        ], $statusCode);
    }

    public static function error($message, $statusCode = 400)
    {
        return response()->json([
            'statusCode' => $statusCode,
            'success'    => false,
            'message'    => $message,
            'data'       => null,
        ], $statusCode);
    }
}
