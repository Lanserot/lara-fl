<?php

declare(strict_types=1);

namespace Infrastructure\Tools;

use Illuminate\Http\JsonResponse;
use App\Enums\HttpStatuses;

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
