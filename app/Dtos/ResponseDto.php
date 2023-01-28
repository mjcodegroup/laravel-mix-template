<?php

namespace App\Dtos;

class ResponseDto
{
    const OK = 200;
    const CREATED = 201;
    const BAD_REQUEST = 400;
    const UNAUTHORIZED = 401;
    const FORBIDDEN = 403;
    const NOT_FOUND = 404;
    const INTERNAL_SERVER_ERROR = 500;
    private static function statusArray($code)
    {
        $arrayStatus = [
            '300' => 'Multiple Choice',
            '301' => 'Moved Permanently',
            '302' => 'Found',
            '304' => 'Not modified',
            '400' => 'Bad Request',
            '401' => 'Unauthorized',
            '402' => 'Payment Required',
            '403' => 'Forbidden',
            '404' => 'Not Found',
            '500' => 'Internal Server Error',
        ];
        return $arrayStatus[$code] ?? null;
    }

    public static function success($code, $data = [], $message = null)
    {
        $responses = [
            'message' => $message ?? 'Operation realized successfully',
            'info' => $data
        ];
        return response()->json($responses, $code);
    }

    public static function error($message, $code)
    {
        if ($code > 500) {
            $code = 500;
        }
        $statusResponse = self::statusArray($code);
        if (!$statusResponse) {
            $code = 400;
            $statusResponse = 'Bad Request';
        }
        $arrayResponse =  [
            'statusCode' => $code,
            'message' => $message,
        ];
        $arrayResponse['error'] = str_replace(' ', '_', strtoupper($statusResponse));
        return response()->json($arrayResponse, $code);
    }
}