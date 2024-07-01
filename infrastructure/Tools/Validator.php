<?php

declare(strict_types=1);

namespace Infrastructure\Tools;

use Symfony\Component\HttpFoundation\Response;
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
            return response()->json(['message' => $message])->setStatusCode(Response::HTTP_BAD_REQUEST);
        }

        return null;
    }
}
