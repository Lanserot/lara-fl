<?php

declare(strict_types=1);

namespace Infrastructure\Tools;

use Illuminate\Http\JsonResponse;

/**
 * Class JsonFormatter
 * @package Infrastructure\Tools
 */
class JsonFormatter
{
    public static function makeAnswer(int $status_code, string $message = ''): JsonResponse
    {
        if($message){
            $message = ['message' => $message];
        }

        return response()->json($message)->setStatusCode($status_code);
    }
}
