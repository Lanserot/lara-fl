<?php

declare(strict_types=1);

namespace Infrastructure\Tools;

use Buisness\Enums\HttpStatuses;
use Illuminate\Http\JsonResponse;

class Validator
{
    public static function validateData(\Illuminate\Validation\Validator $validator): ?JsonResponse
    {
        if ($validator->fails()) {
            $errors = $validator->errors();
            $message = '';
            foreach ($errors->all() as $error) {
                $message .= $error . ".";
            }
            return response()->json(['message' => $message])->setStatusCode((HttpStatuses::BAD_REQUEST)->value);
        }

        return null;
    }
}
